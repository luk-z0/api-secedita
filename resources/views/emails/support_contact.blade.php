<x-mail::message>
# Novo Contato do Portal SEDUC

Você recebeu uma nova mensagem de suporte de **{{ $data['name'] }}**.

<x-mail::panel>
**Assunto:** {{ $data['subject'] }}
**E-mail de resposta:** [{{ $data['email'] }}](mailto:{{ $data['email'] }})
</x-mail::panel>

**Mensagem:** {{ $data['message'] }}

<x-mail::button :url="'mailto:' . $data['email']" color="success">
Responder ao Usuário
</x-mail::button>

Atenciosamente,
Equipe de Tecnologia - SEDUC Itapissuma
</x-mail::message>
