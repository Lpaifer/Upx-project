<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Formulário</title>
</head>
<body>
@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('formulario.store') }}" method="POST">
    @csrf
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Brand:</label><br>
    <input type="brand" name="brand" required></input><br><br>

    <label>Cur. No:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>BK:</label><br>
    <input type="bk" name="bk" required><br><br>

    <label>Owner do BK:</label><br>
    <input type="owner_bk" name="owner_bk" required></input><br><br>

    <label>PK:</label><br>
    <input type="pk" name="pk" required><br><br>

    <label>PN (Material):</label><br>
    <input type="pn" name="pn" required><br><br>

    <label>Status</label><br>
    <input type="status" name="status" required></input><br><br>

    <label>OE:</label><br>
    <input type="oe" name="oe" required></input><br><br>

    <label>Special Case 1:</label><br>
    <input type="case1" name="case1" required><br><br>

    <label>Special Case 2:</label><br>
    <input type="case2" name="case2" required><br><br>
    
    <label>Special Case 3:</label><br>
    <input type="case3" name="case3" required><br><br>

    <label>Mês from</label><br>
    <input type="month_from" name="month_from" required><br><br>

    <label>Ano from</label><br>
    <input type="year_from" name="year_from" required><br><br>

    <label>Fitment from</label><br>
    <input type="fitment_from" name="fitment_from" required></input><br><br>

    <label>Mês until</label><br>
    <input type="month_until" name="month_until" required></input><br><br>

    <label>Ano until</label><br>
    <input type="year_until" name="year_until" required><br><br>

    <label>Fitment until</label><br>
    <input type="fitment_until" name="fitment_until" required><br><br>
    
    <label>Criteria for</label><br>
    <input type="criteria" name="criteria" required><br><br>

    <label>Criteria not for</label><br>
    <input type="criteria_not" name="criteria_not" required><br><br>

    <label>Comentario PM</label><br>
    <input type="comments" name="comments" required></input><br><br>

    <label>Motivo do Link</label><br>
    <input type="reason" name="reason" required><br><br>

    <label>BU</label><br>
    <input type="bu" name="bu" required></input><br><br>

    <label>Solicitante:</label><br>
    <input type="requester" name="requester" required></input><br><br>

    <label>Data da Soliitação</label><br>
    <input type="date" name="date" required><br><br>

    <label>Data Envio País</label><br>
    <input type="send_date" name="send_date" required><br><br>
    
    <label>Data do Upload</label><br>
    <input type="upload_date" name="upload_date" required><br><br>

    <label>Tempo upload(dias úteis)</label><br>
    <input type="upload_time" name="upload_time" required><br><br>

    <label>Remarks FAS</label><br>
    <input type="remarks" name="remarks" required></input><br><br>

    <label>Comentário Remark</label><br>
    <input type="comment_remark" name="comment_remark" required><br><br>

    <label>Resposta do PM</label><br>
    <input type="answer_pm" name="answer_pm" required><br><br>

    <label>Resposta MDT</label><br>
    <input type="anwser_mdt" name="answer_mdt" required></input><br><br>

    <button type="submit">Enviar</button>
</form>
</body>
</html>
