<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resposta;
use illuminate\Support\Facades\Http;

class FormularioController extends Controller
{
    public function index()
    {
        return view('formulario');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'brand' => 'required|string|max:255',
            'cur_no' => 'required|string|max:255',
            'pk' => 'required|string|max:255',
            'pn' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'comments' => 'required|string',
            'reason' => 'required|string',
            'bu' => 'required|string',
            'requester' => 'required|string',
            'date' => 'required|date',
        ]);

        if ($request->bk !== $request->brand . $request->cur_no) {
            return back()->withErrors(['bk' => 'O campo BK deve ser a concatenação de Brand e Cur. No.'])->withInput();
        }

        $dados = $request->only([
            'nome', 'email', 'brand', 'cur_no', 'bk', 'owner_bk',
            'pk', 'pn', 'status', 'oe', 'case1', 'case2', 'case3',
            'month_from', 'year_from', 'fitment_from',
            'month_until', 'year_until', 'fitment_until',
            'criteria', 'criteria_not', 'comments', 'reason',
            'bu', 'requester', 'date', 'send_date', 'upload_date',
            'upload_time', 'remarks', 'comment_remark',
            'answer_pm', 'answer_mdt'
        ]);

        Resposta::create($dados);

        Http::post('https://seu-webhook-url.com/endpoint', $dados);

        return redirect()->back()->with('success', 'Peça Cadastrada com Sucesso!');
    }
}
