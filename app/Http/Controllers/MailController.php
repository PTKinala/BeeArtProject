<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\DB;


class MailController extends Controller
{

    public function someMethod($data)
    {
        // $data สามารถเป็นอาร์กิวเมนต์ที่คุณต้องการส่งไปยัง someMethod ใน MailController

        // สร้างอ็อบเจกต์ของ MailController และเรียกใช้เมธอด index พร้อมส่ง $data เป็นพารามิเตอร์
      /*   $mailController = new MailController();
        return $mailController->index($data); */

        index();
    }



     public function index($data) {

        $gmail = DB::table('gmail')
        ->get();


                $mailData = [
                    'title' => 'Mail from ItSolutionStuff.com',
                    'body' => 'This is for testing email using smtp.',
                    'content' => $data
                ];

                if (count($gmail) > 0) {
                    Mail::to($gmail[0]->gmail)->send(new DemoMail($mailData));
                    $message = "Email is sent successfully.";
                } else {
                    $message = "No email addresses found in the database.";
                }

                return $message;
            }
}