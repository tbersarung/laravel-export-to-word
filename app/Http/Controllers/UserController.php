<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'users' => User::all(),
        ]);
    }

    public function show(User $user)
    {
        return view('user.show', [
            'user' => $user,
        ]);
    }

    public function export(User $user)
    {
        $template = new \PhpOffice\PhpWord\TemplateProcessor('word/user.docx');
        $template->setValue('id', $user->id);
        $template->setValue('name', $user->name);
        $template->setValue('email', $user->email);
        $template->setValue('address', $user->address);
        $fileName = $user->name;
        $template->saveAs($fileName . '.docx');
        return response()->download($fileName . '.docx')->deleteFileAfterSend(true);
    }
}
