<?php

namespace App\Http\Controllers\Api;

use App\Helper\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $validator = Validator::make($data,
            [
                'name' => 'required|max:191',
                'subject' => 'required',
                'email' => 'required|email',
                'message' => 'required|max:5000',
            ]);

        if ($validator->fails()) {
            return ResponseHelper::fail($validator->errors()->first(), ResponseHelper::UNPROCESSABLE_ENTITY_EXPLAINED);
        }

        $contact = new Contact();
        $contact->name = $data["name"];
        $contact->subject = $data["subject"];
        $contact->email = $data["email"];
        $contact->message = $data["message"];
        $contact->type = 0;

        if ($contact->save()) {
            return ResponseHelper::success(array(), null, "Save Successfully!");
        }
        return ResponseHelper::fail("Something Went Wrong", 500);
    }
}
