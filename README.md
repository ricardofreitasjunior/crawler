# crawler

## Etapa 2

O candidato deve implementar um sistema que faça uma requisição HTTP simples a uma lista de URLs cadastradas por outro sistema (etapa 1). Para cada requisição a resposta deve ser armazenada de forma que o sistema 1 tenha acesso, bem como o 'status code' da resposta.

Orientações para a etapa 2:
- Esse sistema não é acessível pelo usuário final, não tendo qualquer tipo de painel de gerenciamento.
- O candidato pode implementar, da maneira que julgar necessário, um sistema que leia constantemente as URLs cadastradas pelo sistema da etapa 1, faça uma requisição HTTP à URL e armazene a resposta e o status code onde fiquem acessíveis pelo sistema da etapa 1.

Orientações gerais e extras:
- O sistema 2 pode ser implementado como um daemon, lançando dois processos filhos para efetivamentne executarem o trabalho de acessar as URLs que estão na fila e armazenar o resultado desse acesso.
- A implementação pode ser feita em qualquer plataforma, AWS, Azure, Linode, ... quaisquer custos decorrentes da implementação desses sistemas será reembolsado até o limite de R$ 100,00.
- É permitido ao usuário a utilização de qualquer framework ou tecnologia que facilite ou mesmo implemente exatamente o que está sendo requisitado nas etapas 1 e 2. Por exemplo, Laravel Queues (https://laravel.com/docs/5.5/queues).
- Não é requisito, mas um diferencial àqueles candidatos que implementarem o sistema 1 utilizando alguma tecnologia de frontend como Bootstrap, ExtJS, React, VueJS, etc.

## Configurações

### Banco de dados
- App/Config/Database
-- Importante: este protótipo foi desenvolvido utilizando o php 5.6 e o mysql 5.7
-- Informação os dados de acesso no array $localhost
-- importar o arquivo database.sql para o seu banco de dados

### Execução do sistema
- dentro da pasta /public executar o seguinte comando em seu terminal: php -S localhost:8080
- acessando a url do sistema, automaticamente executará o crawler
--------------------------------------------------------------------------------

## @todo:
- Salvar arquivos internos da Url cadastrada, tipo css, js, mp4, jpeg,...