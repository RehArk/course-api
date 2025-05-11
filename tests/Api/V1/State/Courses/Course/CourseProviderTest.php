<?php

namespace App\Tests\Api\V1\State\Courses\Course;

use App\Api\V1\State\Courses\Course\CourseProvider;
use App\Api\V1\Mapper\Courses\Course\CourseMapper;
use App\Entity\Course;
use App\Repository\CourseRepository;
use ApiPlatform\Metadata\Operation;
use App\ApiResource\V1\Course as ApiCourse;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseProviderTest extends TestCase
{
    public function testProvideReturnsMappedCourse()
    {
        $id = '1';
        $title = 'Title';

        $course = $this->createMock(Course::class);
        $dto = new ApiCourse(
            $id,
            $title,
            new DateTime(),
            new DateTime()
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\CourseRepository $repository */
        $repository = $this->createMock(CourseRepository::class);
        $repository->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $id])
            ->willReturn($course);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Course\CourseMapper $mapper */
        $mapper = $this->createMock(CourseMapper::class);
        $mapper->expects($this->once())
            ->method('fromEntity')
            ->with($course)
            ->willReturn($dto);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Symfony\Component\HttpFoundation\RequestStack $requestStack */
        $requestStack = $this->createMock(RequestStack::class);

        $provider = new CourseProvider($repository, $mapper, $requestStack);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $result = $provider->provide($operation, ['id' => $id]);

        $this->assertSame($dto, $result);
    }

    public function testProvideThrowsNotFoundWhenCourseMissing()
    {
        $id = '1';

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\CourseRepository $repository */
        $repository = $this->createMock(CourseRepository::class);
        $repository
            ->method('findOneBy')
            ->with(['id' => $id])
            ->willReturn(null)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Course\CourseMapper $mapper */
        $mapper = $this->createMock(CourseMapper::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Symfony\Component\HttpFoundation\RequestStack $requestStack */
        $requestStack = $this->createMock(RequestStack::class);

        $provider = new CourseProvider($repository, $mapper, $requestStack);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $this->expectException(NotFoundHttpException::class);

        $provider->provide(
            $operation,
            ['id' => $id]
        );
    }
}
