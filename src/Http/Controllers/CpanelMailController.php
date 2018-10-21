<?php
namespace Naif\CpanelMail\Http\Controllers;

use Illuminate\Http\Request;

class CpanelMailController
{
    protected $cpanel;

    public function __construct()
    {
        try {
            $this->cpanel = app()->make(Cpanel::class);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function index()
    {
        $emails = $this->cpanel->email()->fetch()->all();
        $list = [];
        foreach ($emails as $email){
            array_push($list,[
                'email'=> $email->email,
                'quota'=> $email->_diskquota,
                'usage'=> $email->_diskused,
                'delete' => 'Delete'
            ]);
        }
        return response()->json($list);
    }

    public function add(Request $request)
    {
        if ($request->email_address) {
            $email = new Email();
            $email->email = $request->email_address . '@' . env('CPANEL_DOMAIN');
            try {
               $response = $this->cpanel->email()->store($email, $request->password, (float)$request->quota);
               if ($response->count() > 0) {
                   return response()->json(['status'=>'success', 'message'=>'Email address has been added successfully']);
               }
                return response()->json(['status'=>'error', 'message'=>'Failed to add email address!']);
            } catch (\Exception $e) {
                return response()->json(['status'=>'error', 'message'=>$e->getMessage()]);
            }
        }
    }

    public function delete(Request $request)
    {
        if ($request->email_address) {
            $email = new Email();
            $email->domain = env('CPANEL_DOMAIN');
            $email->user = $request->email_address;
            try {
                $response = $this->cpanel->email()->destroy($email);
                if ($response) {
                    return response()->json(['status'=>'success', 'message'=>'Email address has been deleted successfully']);
                }
                return response()->json(['status'=>'error', 'message'=>'Failed to delete email address!']);
            } catch (\Exception $e){
                return response()->json(['status'=>'error', 'message'=>$e->getMessage()]);
            }
        }
    }
}