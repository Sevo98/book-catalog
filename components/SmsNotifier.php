<?php
namespace app\components;

use Yii;
use yii\base\Component;

class SmsNotifier extends Component
{
    public $apiKey = 'emulator';
    public $logFile = 'sms_notifications.log';

    public function sendNewBookNotification(string $phone, string $authorName, string $bookName = ''): bool
    {
        $message = 'Добавлена новая книга от ' . $authorName;
        if ($bookName) {
            $message .= ": «{$bookName}»";
        }



        $url = sprintf(
            'https://smspilot.ru/api.php?send=%s&to=%s&apikey=%s',
            urlencode($message),
            urlencode($phone),
            urlencode($this->apiKey)
        );

        $result = false;
        $response = '';

        try {
            $response = file_get_contents($url);
            $result = $response && stripos($response, 'SUCCESS') !== false;
        } catch (\Throwable $e) {
            $response = 'ERROR: ' . $e->getMessage();
        }

        $this->log($phone, $authorName, $bookName, $result, $response);
        return $result;
    }

    private function log(string $phone, string $authorName, string $bookName, bool $success, string $response): void
    {
        $logPath = Yii::getAlias('@webroot') . '/logs/' . $this->logFile;
        $timestamp = date('Y-m-d H:i:s');
        $status = $success ? '✓ SENT' : '✗ FAILED';

        $logEntry = sprintf(
            "[%s] %s | Phone: %s | Author: %s | Book: %s | Response: %s\n",
            $timestamp,
            $status,
            $phone,
            $authorName,
            $bookName ?: 'N/A',
            trim($response)
        );

        file_put_contents($logPath, $logEntry, FILE_APPEND | LOCK_EX);
    }
}