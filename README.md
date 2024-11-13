# Convenia-API-teste

## Descrição do projeto:
  Este repositório contém uma API que possui as seguintes funcionalidades: 
 - CRUD de employee (Create, Read/Retrieve, Update e Delete),
 - Criação, login e logout de usuário administrador (user),
 - Upload de documento no formato CSV com listagem de colaboradores, para inserção assíncrona em massa no banco de dados,
 - Envio de email informando inserção em massa com sucesso.
 - Testes automatizados de integração validando as principais rotas.

## Principais tecnologias/bibliotecas/linguagens utilizadas:
  - Laravel v11.31
  - PHP v8.3
  - MySQL v8.0.40
  - PHPUnit v11.4.3
  - Passport v12.3.1
  - SQLite v3
  - Predis v2.2.2

## Como executar o projeto:
  Passo-a-passo:
   1. git clone git@github.com:AttilaBS/convenia-test.git
   2. na pasta raiz do repositório, digitar, em sequência:
      - composer install
      - php artisan migrate
   3. criar passport api token, digitar:
      - php artisan passport:client --password
   4. adicionar no .env, nas variáveis de ambiente:
      - PASSPORT_PERSONAL_ACCESS_CLIENT_ID
      - PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET
      - os valores recebidos no comando do passo 3
   5. verificar se na tabela oauth_clients a coluna providers está com o valor users e se personal_access_client como 1.
    Alterar se necessário.
   6. digitar:
      - php artisan serve
   7. iniciar as filas. Digitar em terminais separados:
      - php artisan queue:work --queue=list         (fila para processamento do arquivo csv)
      - php artisan queue:work --queue=employees    (fila para a inserção em massa no banco de dados dos colaboradores)
      - php artisan queue:work                      (fila para envio do email via notification facade)
   8. para testar o envio de email, uma sugestão é o uso do serviço MailTrap (o envio é realizado após 1 minuto)
      OBS.: No .env.example há sugestões de variáveis de ambiente para gmail e mailtrap, ambos testados e funcionais
   9. para efetuar os testes automatizados, digitar no terminal:
      -- php artisan test
      -- php artisan test --coverage        (para testes informando a porcentagem de cobertura de código (necessário xdebug configurado no modo coverage))
   
## Observações finais:
    a) em um arquivo separado, será enviada a collection das rotas com os respectivos payloads

    b) para verificação de implementação de cache via redis/predis, verificar a rota api/employee/list
