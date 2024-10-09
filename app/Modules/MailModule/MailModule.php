<?php

namespace App\Modules\MailModule;

use App\Mail\OtpMail;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailModule
{
    public static function sendAccountRecoveryMail(Request $request): bool
    {

        $mail = new OtpMail([
            "title" => "Account Recovery - Bill Payment System",
            "greeting" => "Hello",
            "name" => $request->first_name,
            "intro" => "We received a request to recover your account associated with our Bill Payment System.",
            "text" => "Your One-Time Password (OTP) is: " . $request->otp . ".\n" .
                      "This OTP will expire in " . $request->otp_expiry . " minutes.",
            "outro" => "If you did not request this, please disregard this email.",
            "companyName" => "Bill Payment System",
        ]);

        $status = Mail::mailer("task_smtp")
            ->to($request->email)
            ->send($mail);

        return $status ? true : false;
    }

    public static function sendWelcomeMail(Request $request): bool
    {
        $mail = new WelcomeMail([
            "title" => "Welcome to the Bill Payment System",
            "greeting" => "Welcome to the Bill Payment System!",
            "name" => $request->first_name,
            "intro" => "We're thrilled to have you join us! Prepare to manage your bills efficiently and conveniently.",
            "text" => "With our Bill Payment System, you can easily view, manage, and pay your bills online, set reminders, and enjoy a seamless payment experience. Our goal is to simplify your financial management and help you stay on top of your payments.",
            "outro" => "Let's get started on your journey towards hassle-free bill payments!",
            "companyName" => "Bill Payment System",
        ]);

        $status = Mail::mailer("task_smtp")
            ->to($request->email)
            ->send($mail);

        return $status ? true : false;
    }
}