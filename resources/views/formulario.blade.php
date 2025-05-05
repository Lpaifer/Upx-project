@extends('layouts.app')

@section('content')
    @if(session('success'))
        <p class="success-message">{{ session('success') }}</p>
    @endif

    <form action="{{ route('formulario.store') }}" method="POST" class="formulario">
        @csrf

        {{-- CAMPOS OBRIGATÓRIOS (com asterisco vermelho) --}}
        <div class="form-group"><label class="required">Nome</label><input type="text" name="nome" required></div>

        <div class="form-group"><label class="required">Email</label><input type="email" name="email" required></div>
        <div class="form-group">
            <label class="required">Brand</label>
            <input type="text" name="brand" id="brand" required>
        </div>

        <div class="form-group">
            <label class="required">Cur. No</label>
            <input type="text" name="cur_no" id="cur_no" required>
        </div>

        <div class="form-group"><label class="required">PK</label><input type="text" name="pk" required></div>
        <div class="form-group"><label class="required">PN (Material)</label><input type="text" name="pn" required></div>
        <div class="form-group"><label class="required">Status</label><input type="text" name="status" required></div>
        <div class="form-group"><label class="required">Comentário PM</label><input type="text" name="comments" required></div>
        <div class="form-group"><label class="required">Motivo do Link</label><input type="text" name="reason" required></div>
        <div class="form-group"><label class="required">BU</label><input type="text" name="bu" required></div>
        <div class="form-group"><label class="required">Solicitante</label><input type="text" name="requester" required></div>
        <div class="form-group"><label class="required">Data da Solicitação</label><input type="date" name="date" required></div>

        {{-- CAMPOS OPCIONAIS --}}
        <div class="form-group">
            <label class="required">BK</label>
            <input type="text" name="bk" id="bk" readonly required>
        </div>

        <div class="form-group">
            <label class="required">Owner do BK</label>
            <input type="text" name="owner_bk" id="owner_bk" readonly required>
        </div>

        <div class="form-group"><label>OE</label><input type="text" name="oe"></div>
        <div class="form-group"><label>Special Case 1</label><input type="text" name="case1"></div>
        <div class="form-group"><label>Special Case 2</label><input type="text" name="case2"></div>
        <div class="form-group"><label>Special Case 3</label><input type="text" name="case3"></div>
        <div class="form-group"><label>Mês From</label><input type="text" name="month_from"></div>
        <div class="form-group"><label>Ano From</label><input type="number" name="year_from"></div>
        <div class="form-group"><label>Fitment From</label><input type="text" name="fitment_from"></div>
        <div class="form-group"><label>Mês Until</label><input type="text" name="month_until"></div>
        <div class="form-group"><label>Ano Until</label><input type="number" name="year_until"></div>
        <div class="form-group"><label>Fitment Until</label><input type="text" name="fitment_until"></div>
        <div class="form-group"><label>Criteria For</label><input type="text" name="criteria"></div>
        <div class="form-group"><label>Criteria Not For</label><input type="text" name="criteria_not"></div>
        <div class="form-group"><label>Data Envio País</label><input type="date" name="send_date"></div>
        <div class="form-group"><label>Data do Upload</label><input type="date" name="upload_date"></div>
        <div class="form-group"><label>Tempo upload (dias úteis)</label><input type="number" name="upload_time"></div>
        <div class="form-group"><label>Remarks FAS</label><input type="text" name="remarks"></div>
        <div class="form-group"><label>Comentário Remark</label><input type="text" name="comment_remark"></div>
        <div class="form-group"><label>Resposta do PM</label><input type="text" name="answer_pm"></div>
        <div class="form-group"><label>Resposta MDT</label><input type="text" name="answer_mdt"></div>

        {{-- BOTÃO --}}
        <div class="form-group full-width">
            <button type="submit">Enviar Peça Para Cadastro</button>
        </div>
    </form>
@endsection
