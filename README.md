# API Patients (Laravel) - JWT

Projeto exemplo: CRUD de pacientes e prontuários aninhados, autenticação JWT e suporte a Soft Delete.

Visão geral

- Laravel 12
- Autenticação via JWT (tymon/jwt-auth)
- SoftDeletes aplicado a `Patient` e `Record` (campo `deleted_at`)

Rodando localmente (com Docker)

1.  Copie/ajuste `.env` (ex.: `cp .env.example .env`) e confirme as variáveis de ambiente. - Se rodando com `docker-compose`, defina `DB_HOST=db` no `.env` (o serviço do compose se chama `db`).
    Após isso, utilize o seguinte comando

    ```powershell
    php artisan key:generate
    ```

2.  Subir containers:

```powershell
docker-compose up -d --build
```

3. Acessar o container da aplicação para rodar comandos (opcional):

```powershell
docker-compose exec app bash
# ou rodar comandos direto: docker-compose exec app php artisan migrate
```

4. Rodar migrations e seeders:

```powershell
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

5. Rodar o laravel em uma porta

```powershell
php artisan serve
```

Autenticação (JWT)

Utilizar a porta http://localhost:8000

- Fazer login:

    POST /api/login
    Body: { "email": "admin@example.com", "password": "senha123" }

    Resposta: { "token": "...", "token_type": "Bearer" }

- Header para chamadas autenticadas:

    Authorization: Bearer {token}

Observação: as rotas de API estão protegidas por `auth:api`. Se preferir usar o guard jwt, ajuste `config/auth.php` para que o guard `api` use o driver `jwt`.

Endpoints principais

- Patients
    - GET /api/patients (listar; suporta query: `?per_page=15`)
    - POST /api/patients (criar)
    - GET /api/patients/{id} (visualizar)
    - PUT /api/patients/{id} (atualizar)
    - DELETE /api/patients/{id} (soft delete)

- Records (prontuários) — aninhados em pacientes
    - GET /api/patients/{patient}/records
    - POST /api/patients/{patient}/records
    - GET /api/patients/{patient}/records/{record}
    - PUT /api/patients/{patient}/records/{record}
    - DELETE /api/patients/{patient}/records/{record}

Soft deletes - notas importantes

- Os modelos `Patient` e `Record` usam `SoftDeletes`. Ao chamar `delete()` o Eloquent define `deleted_at` em vez de remover a linha.
- Para incluir registros deletados nas queries use `withTrashed()`; para só os deletados use `onlyTrashed()`.
- Para restaurar: `restore()`; para deletar permanentemente: `forceDelete()`.
- Se precisar soft-delete em cascata (deletar prontuários ao soft-deletar paciente), há um hook no model que pode chamar `$patient->records()->each->delete()` no evento `deleting`.

Exemplos de teste (curl)

- Login e salvar token:

```bash
curl -s -X POST http://localhost:8000/api/login \
	-H "Content-Type: application/json" \
	-d '{"email":"admin@example.com","password":"senha123"}'
```

- Deletar (soft delete) paciente — requer token Bearer:

```bash
curl -X DELETE http://localhost:8000/api/patients/1 \
	-H "Authorization: Bearer <TOKEN>" \
	-H "Accept: application/json" -i
```

Dicas e troubleshooting

- Se estiver usando `docker-compose`, defina `DB_HOST=db` no seu `.env` (o serviço chama-se `db` no compose).

Mais

- O `User` model e o `config/auth.php` foram ajustados para suportar JWT conforme instruções no projeto.

--
README gerado/atualizado automaticamente pelo time de desenvolvimento — inclui instruções de JWT e SoftDeletes.
