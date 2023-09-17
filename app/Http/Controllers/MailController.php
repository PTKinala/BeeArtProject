<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
                    'title' => $data[0] ."  ". $data[1],
                    'body' => 'รายละเอียด'.$data[0] . "  ". $data[1],
                    'content' => $data
                ];

                if (count($gmail) > 0) {
                    Mail::to($gmail[0]->gmail)->send(new OrderMail($mailData));
                    $message = "Email is sent successfully.";
                } else {
                    $message = "No email addresses found in the database.";
                }

                return $message;
            }

    public function customer_mail($data) {
                
                $gmail = Auth::user()->email;


                $mailData = [
                    'title' => $data[0] ."  ". $data[1],
                    'body' => 'รายละเอียด'.$data[0] . "  ". $data[1],
                    'content' => $data
                ];

                if ($gmail) {
                    Mail::to($gmail)->send(new OrderMail($mailData));
                    $message = "Email is sent successfully.";
                } else {
                    $message = "No email addresses found in the database.";
                }

                return $message;
            }
}