<?php

use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class LanguageFilesTest extends CIUnitTestCase
{
    public function testEnglishLanguageFilesMatchTraditionalChineseKeys(): void
    {
        $zhTwFiles = glob(APPPATH . 'Language/zh-TW/*.php');

        $this->assertNotFalse($zhTwFiles);
        $this->assertNotEmpty($zhTwFiles);

        foreach ($zhTwFiles as $zhTwFile) {
            $fileName = basename($zhTwFile);
            $enFile = APPPATH . 'Language/en/' . $fileName;

            $this->assertFileExists($enFile, "Missing English language file: {$fileName}");

            $zhTwKeys = $this->flattenKeys(require $zhTwFile);
            $enKeys = $this->flattenKeys(require $enFile);

            sort($zhTwKeys);
            sort($enKeys);

            $this->assertSame($zhTwKeys, $enKeys, "Language keys differ in {$fileName}");
        }
    }

    /**
     * @param array<string, mixed> $items
     *
     * @return list<string>
     */
    private function flattenKeys(array $items, string $prefix = ''): array
    {
        $keys = [];

        foreach ($items as $key => $value) {
            $fullKey = $prefix === '' ? (string) $key : $prefix . '.' . $key;

            if (is_array($value)) {
                array_push($keys, ...$this->flattenKeys($value, $fullKey));

                continue;
            }

            $keys[] = $fullKey;
        }

        return $keys;
    }
}
