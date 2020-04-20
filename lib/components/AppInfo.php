<?php


namespace lib\components;


class AppInfo
{

    const APP_NAME = 'The app name'; // TODO what name do we give our app?

    private static $baseUrl = '/';

    public static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }

    public static function urlCss(string $filename): string
    {
        return self::$baseUrl . 'css/' . $filename;
    }

    public static function urlStartPage(): string
    {
        return self::$baseUrl . 'index.php';
    }

    public static function urlLoginPage(): string
    {
        return self::$baseUrl . 'login.php';
    }

    public static function urlRegisterPage(): string
    {
        return self::$baseUrl . 'register.php';
    }

    public static function urlInbox(): string
    {
        return self::$baseUrl . 'inbox.php';
    }
}