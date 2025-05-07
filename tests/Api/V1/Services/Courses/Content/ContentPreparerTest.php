<?php

namespace App\Tests\Api\V1\Services\Courses\Content;

use App\Api\V1\Dto\Courses\Content\ContentInput;
use App\Api\V1\Dto\Courses\Content\PreparedContentInput;
use App\Api\V1\Services\Courses\Content\ContentPreparer;
use App\Entity\Chapter;
use App\Entity\ContentType;
use App\Repository\ChapterRepository;
use App\Repository\ContentRepository;
use App\Repository\ContentTypeRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerInterface;

class ContentPreparerTest extends TestCase
{

    public function testPrepare()
    {
        $chapter_id = '1';
        $parent_id = null;
        $content_type_id = 1;
        $default_content = '<p>Ceci est une chaine</p>';

        $contentInput = new ContentInput();
        $contentInput->chapter_id = $chapter_id;
        $contentInput->parent_id = $parent_id;
        $contentInput->content_type_id = $content_type_id;
        $contentInput->default_content = $default_content;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Chapter $chapter */
        $chapter = $this->createMock(Chapter::class);
        $chapter
            ->method('getId')
            ->willReturn($chapter_id)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\ContentType $contentType */
        $contentType = $this->createMock(ContentType::class);
        $contentType
            ->method('getId')
            ->willReturn($content_type_id)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $chapterRepository */
        $chapterRepository = $this->createMock(ChapterRepository::class);
        $chapterRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $contentInput->chapter_id])
            ->willReturn($chapter)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentRepository $contentRepository */
        $contentRepository = $this->createMock(ContentRepository::class);
        $contentRepository
            ->expects($this->exactly(2))
            ->method('findOneBy')
            ->willReturnOnConsecutiveCalls(null, null)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentTypeRepository $contentTypeRepository */
        $contentTypeRepository = $this->createMock(ContentTypeRepository::class);
        $contentTypeRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $contentInput->content_type_id])
            ->willReturn($contentType)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Symfony\Component\HtmlSanitizer\HtmlSanitizer $htmlSanitizer */
        $htmlSanitizer = $this->createMock(HtmlSanitizerInterface::class);
        $htmlSanitizer->method('sanitize')->willReturn($default_content);

        $contentPreparer = new ContentPreparer(
            $chapterRepository,
            $contentRepository,
            $contentTypeRepository,
            $htmlSanitizer
        );

        $res = $contentPreparer->prepare(
            $contentInput
        );

        $this->assertEquals($res, new PreparedContentInput(
            $chapter,
            null,
            null,
            $contentType,
            $default_content
        ));
    }

    public function testPrepareWithNoChapterFail()
    {
        $chapter_id = '1';
        $parent_id = null;
        $content_type_id = 1;
        $default_content = '<p>Ceci est une chaine</p>';

        $contentInput = new ContentInput();
        $contentInput->chapter_id = $chapter_id;
        $contentInput->parent_id = $parent_id;
        $contentInput->content_type_id = $content_type_id;
        $contentInput->default_content = $default_content;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $chapterRepository */
        $chapterRepository = $this->createMock(ChapterRepository::class);
        $chapterRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $contentInput->chapter_id])
            ->willReturn(null)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentRepository $contentRepository */
        $contentRepository = $this->createMock(ContentRepository::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentTypeRepository $contentTypeRepository */
        $contentTypeRepository = $this->createMock(ContentTypeRepository::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Symfony\Component\HtmlSanitizer\HtmlSanitizer $htmlSanitizer */
        $htmlSanitizer = $this->createMock(HtmlSanitizerInterface::class);

        $contentPreparer = new ContentPreparer(
            $chapterRepository,
            $contentRepository,
            $contentTypeRepository,
            $htmlSanitizer
        );

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
        $this->expectExceptionMessage('Chapter not found');

        $contentPreparer->prepare(
            $contentInput
        );
    }

    public function testPrepareWithNoContentTypeFail()
    {
        $chapter_id = '1';
        $parent_id = null;
        $content_type_id = 1;
        $default_content = '<p>Ceci est une chaine</p>';

        $contentInput = new ContentInput();
        $contentInput->chapter_id = $chapter_id;
        $contentInput->parent_id = $parent_id;
        $contentInput->content_type_id = $content_type_id;
        $contentInput->default_content = $default_content;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Chapter $chapter */
        $chapter = $this->createMock(Chapter::class);
        $chapter
            ->method('getId')
            ->willReturn($chapter_id)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $chapterRepository */
        $chapterRepository = $this->createMock(ChapterRepository::class);
        $chapterRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $contentInput->chapter_id])
            ->willReturn($chapter)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentRepository $contentRepository */
        $contentRepository = $this->createMock(ContentRepository::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentTypeRepository $contentTypeRepository */
        $contentTypeRepository = $this->createMock(ContentTypeRepository::class);
        $contentTypeRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $contentInput->content_type_id])
            ->willReturn(null)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Symfony\Component\HtmlSanitizer\HtmlSanitizer $htmlSanitizer */
        $htmlSanitizer = $this->createMock(HtmlSanitizerInterface::class);

        $contentPreparer = new ContentPreparer(
            $chapterRepository,
            $contentRepository,
            $contentTypeRepository,
            $htmlSanitizer
        );

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
        $this->expectExceptionMessage('Content type not found');

        $contentPreparer->prepare(
            $contentInput
        );
    }
}
