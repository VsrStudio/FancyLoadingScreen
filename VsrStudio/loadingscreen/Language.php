<?php

namespace spicearth\loadingscreen;

/**
 * Class Language
 * @package VsrStudio\loadingscreen
 */
class Language
{
    /** @var string */
    private $language = "ind";

    /** @var int  */
    public const ERROR_NO_PLAYER = 1;

    /** @var int  */
    public const EMPTY_ARGS = 2;

    /** @var int  */
    public const WORLD_NOT_EXISTS = 3;

    /** @var int  */
    public const WORLD_IS_NULL = 4;

    /** @var int  */
    public const TRANSFER_NOT_EXISTS = 5;

    /** @var int  */
    public const PERMISSION = 6;

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return string
     */
    public function setLanguage(string $language): string
    {
        return $this->language = $language;
    }

    /**
     * @param int $type
     * @return string
     */
    public static function translateLanguage(int $type, string $target = ""): string
    {
        switch ($target) {
            case "ind":
                $result = self::translateIndonesian($type);
                break;
            default:
                $result = self::translateEnglish($type);
        }
        return $result;
    }

    /**
     * @param int $type
     * @return string
     */
    private static function translateIndonesian(int $type): string
    {
        switch ($type) {
            case self::ERROR_NO_PLAYER:
                return "Kamu bukan player";
            case self::EMPTY_ARGS:
                return "Itu bukan nama world";
            case self::WORLD_NOT_EXISTS:
                return "World tidak ada";
            case self::WORLD_IS_NULL:
                return "Kamu harus load world nya terlebih dahulu";
            case self::TRANSFER_NOT_EXISTS:
                return "Anda perlu membuat World Nether bernama 'transfer' atau World Kamu belum di load";
            case self::PERMISSION:
                return "Kamu tidak punya izin untuk menggunakan command ini";
            default:
                return "Pesan tidak dikenal";
        }
    }

    /**
     * @param int $type
     * @return string
     */
    private static function translateEnglish(int $type): string
    {
        switch ($type) {
            case self::ERROR_NO_PLAYER:
                return "You are not a player";
            case self::EMPTY_ARGS:
                return "That's not a world name";
            case self::WORLD_NOT_EXISTS:
                return "World doesn't exist";
            case self::WORLD_IS_NULL:
                return "You have to load the world first";
            case self::TRANSFER_NOT_EXISTS:
                return "You need to create the Nether world named 'transfer' or Your world is unloaded";
            case self::PERMISSION:
                return "You don't have permission to use this command";
            default:
                return "Unknown message";
        }
    }
}
