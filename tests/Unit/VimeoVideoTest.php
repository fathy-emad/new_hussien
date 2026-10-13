<?php

namespace Tests\Unit;

use App\Support\VimeoVideo;
use PHPUnit\Framework\TestCase;

class VimeoVideoTest extends TestCase
{
    public function test_it_parses_numeric_id(): void
    {
        $this->assertSame('123456789', VimeoVideo::normalize('123456789'));
    }

    public function test_it_parses_vimeo_url_and_embed(): void
    {
        $this->assertSame('123456789', VimeoVideo::normalize('https://vimeo.com/123456789'));
        $this->assertSame(
            '123456789',
            VimeoVideo::normalize('<iframe src="https://player.vimeo.com/video/123456789"></iframe>')
        );
    }

    public function test_it_keeps_privacy_hash(): void
    {
        $this->assertSame('123456789:abc123', VimeoVideo::normalize('https://vimeo.com/123456789/abc123'));
        $this->assertSame('123456789:abc123', VimeoVideo::normalize('123456789:abc123'));
        $this->assertStringContainsString('h=abc123', (string) VimeoVideo::embedUrl('123456789:abc123'));
    }

    public function test_it_rejects_non_vimeo_values(): void
    {
        $this->assertNull(VimeoVideo::normalize('video.mp4'));
        $this->assertNull(VimeoVideo::normalize('https://youtube.com/watch?v=abc'));
        $this->assertFalse(VimeoVideo::hasVideo(''));
    }
}
