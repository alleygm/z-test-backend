<?php

namespace App\Controller\Api;

use App\Entity\Tender;
use App\Entity\TenderStatus;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api', name: 'api_tender_')]
#[OA\Tag(name: 'Tender')]
#[Security(name: 'Bearer')]
#[IsGranted('ROLE_USER')]
class TenderApiController extends AbstractController
{
    private $context = ['json_encode_options' => JSON_UNESCAPED_UNICODE];

    public function __construct(private EntityManagerInterface $em, private SerializerInterface $serializer)
    {
    }

    // -----------------------------------------------------------------------
    // Создание тендера
    // -----------------------------------------------------------------------
    #[Route('/tender', name: 'create', methods: ['POST'])]
    #[OA\Post(
        path: '/api/tender',
        summary: 'Создание тендера',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['externalCode', 'name'],
                properties: [
                    new OA\Property(property: 'externalCode', type: 'string', example: 'EXT123'),
                    new OA\Property(property: 'number', type: 'string', nullable: true, example: 'TN-5544'),
                    new OA\Property(property: 'name', type: 'string', example: 'Закупка оборудования'),
                    new OA\Property(property: 'status', type: 'string', example: 'Закрыто'),
                ]
            )
        ),
    )]
    public function create(Request $request): JsonResponse
    {
        try {
            $tender = $this->serializer->deserialize($request->getContent(), Tender::class, 'json');

            $this->em->persist($tender);
            $this->em->flush();

            return $this->json([
                'id'      => $tender->getId(),
                'message' => 'Тендер создан',
            ], 201);

        } catch (\Throwable $th) {
            return $this->json($th->getMessage(), 400);
        }
    }

    // -----------------------------------------------------------------------
    // Получение одного тендера
    // -----------------------------------------------------------------------
    #[Route('/tender/{id}', name: 'get_one', methods: ['GET'])]
    #[OA\Get(
        path: '/api/tender/{id}',
        summary: 'Получение одного тендера по ID',
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
                example: 5
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Информация о тендере',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'id', type: 'integer'),
                        new OA\Property(property: 'externalCode', type: 'string'),
                        new OA\Property(property: 'number', type: 'string', nullable: true),
                        new OA\Property(property: 'name', type: 'string'),
                        new OA\Property(property: 'status', type: 'string'),
                        new OA\Property(property: 'updatedAt', type: 'string', format: 'date-time'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Тендер не найден')
        ]
    )]
    public function getOne(Request $request, Tender $tender): JsonResponse
    {
        try {
            return $this->json($tender, context: $this->context);
        } catch (\Throwable $th) {
            return $this->json($th->getMessage(), 400);
        }
        
    }

    // -----------------------------------------------------------------------
    // Получение списка тендеров
    // -----------------------------------------------------------------------
    #[Route('/tender', name: 'get_all', methods: ['GET'])]
    #[OA\Get(
        path: '/api/tender',
        summary: 'Получение списка тендеров',
        parameters: [
            new OA\Parameter(
                name: 'name',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string'),
                example: 'Закупка'
            ),
            new OA\Parameter(
                name: 'date',
                in: 'query',
                required: false,
                description: 'Точная дата обновления (формат: Y-m-d H:i:s)',
                schema: new OA\Schema(type: 'string', format: 'date-time'),
                example: '2023-10-05 14:22:00'
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                description: 'Номер страницы (начиная с 1)',
                schema: new OA\Schema(type: 'integer', minimum: 1),
                example: 1
            ),
        ]
    )]
    public function list(Request $request): JsonResponse
    {
        try {
            $name   = $request->query->get('name', '');
            $date   = $request->query->get('date', '');
            $page   = max(1, (int) $request->query->get('page', 1));
            $limit  = 20;
            $offset = ($page - 1) * $limit;

            $qb = $this->em->getRepository(Tender::class)->createQueryBuilder('t');

            if (!empty($name)) {
                $qb->andWhere('t.name LIKE :name')
                    ->setParameter('name', "%$name%");
            }

            if (!empty($date)) {
                $dateObj = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date);
                if ($dateObj === false) {
                    return $this->json([
                        'error' => 'Неверный формат даты. Используйте Y-m-d H:i:s',
                    ], 400);
                }

                $qb->andWhere('t.updatedAt = :date')
                    ->setParameter('date', $dateObj->format('Y-m-d H:i:s'));
            }

            // Добавляем пагинацию
            $qb->setFirstResult($offset)
                ->setMaxResults($limit)
                ->orderBy('t.id', 'DESC');

            $list = $qb->getQuery()->getResult();

            // Формирование ответа
            $result = array_map(fn(Tender $t) => [
                'id'           => $t->getId(),
                'externalCode' => $t->getExternalCode(),
                'number'       => $t->getNumber(),
                'name'         => $t->getName(),
                'status'       => $t->getStatus()->getName(),
                'updatedAt'    => $t->getUpdatedAt()->format('Y-m-d H:i:s'),
            ], $list);

            return $this->json(
                [
                    'page'  => $page,
                    'count' => count($result),
                    'items' => $result,
                ],
                context: $this->context
            );

        } catch (\Throwable $e) {
            return $this->json([
                'error'   => 'Internal server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
