
# Matheus Fernandes Advocacia

Site institucional em HTML + CSS + JavaScript, com formulário de contato via PHP (PHPMailer).

## Configurar o envio de e-mail do formulário de contato

1. Copie `config.example.php` para `config.php`.
2. Preencha `SMTP_USER`, `SMTP_PASS` (use uma **senha de app** do Google, nunca a senha normal da conta — crie em https://myaccount.google.com/apppasswords) e `MAIL_TO`.
3. **Nunca** suba o `config.php` para um repositório público nem o envie para terceiros — ele já está no `.gitignore`.

Alternativamente, configure `SMTP_USER`, `SMTP_PASS` e `MAIL_TO` como variáveis de ambiente no servidor de hospedagem, sem precisar do `config.php`.

## Aviso de segurança (importante)

A versão anterior deste site continha, em `email.php`, um trecho de código que apagava os arquivos do site quando o formulário de contato recebia um valor específico, além de uma senha de e-mail escrita diretamente no código-fonte. Ambos os problemas foram removidos nesta versão. Se essa senha antiga (do Gmail `pablreis@gmail.com`) ainda estiver ativa, troque-a imediatamente.

# SiteMatheus
Site para a agência PDA

https://pblc15.github.io/SiteMatheus/

