<?php

namespace App\Traits;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\Notification;

trait PushNotificationsTrait
{
    public function sendNotification($token, $title, $body)
    {
        try {
            // إنشاء مثيل Firebase
            $factory = (new Factory)
                ->withServiceAccount(config('firebase.credentials.file'));

            // الحصول على خدمة المراسلة
            $messaging = $factory->createMessaging();

            // تحديد هدف الرسالة (token)
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($title, $body));

            // إرسال الرسالة
            $messaging->send($message);


            // return "Notification sent successfully!";
        } catch (\Exception $e) {
            // return "Error sending notification ";
        }
    }

    //
    public function sendNotificationWithImage($token, $title, $body, $imageUrl)
    {
        try {
            $factory = (new Factory)
                ->withServiceAccount(config('firebase.credentials.file'));
    
            $messaging = $factory->createMessaging();
    
            $message = CloudMessage::withTarget('token', $token)
                ->withNotification(Notification::create($title, $body)->withImage($imageUrl));
    
            $messaging->send($message);
    
            echo "Notification with image sent successfully!";
        } catch (\Exception $e) {
            echo "Error sending notification with image: " . $e->getMessage();
        }
    }
}