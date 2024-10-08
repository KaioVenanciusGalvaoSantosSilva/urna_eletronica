# urna_eletronica V 1.7 

Projeto didático para digitalizar a urna eleitoral em ambientes estudantis.

Modelagem do Sistema - draw.io
Projeto deve ser modelado para compreender os requisitos do sistema.

Linguagens e ferramentas utilizadas no projeto:
  HTML5
  CSS3
  JS
  PHP
  SQL - Mysql

![image](https://github.com/user-attachments/assets/161c4643-70ed-4346-8a59-34be7cc98936)


  A contagem é auditável. Não necessita de manipulação por parte do DBA, tabelas auto-gerenciaveis.
  O resultado da votação poderá ser acessado pelo localhost/resultado.

![image](https://github.com/user-attachments/assets/2bef932a-ccf0-47aa-96fd-6156203deef7)

  O acesso via navegador foi escolhido devido a necessidade de suporte a diversos dispositivos, android, ios, desktop entre outros.

  Para votar o usuário precisará escolher os números do candidato e confirmar. Poderá votar em branco, e confirmar.
  No caso de erro deverá corrigir e digitar novamente.

  Toda vez que um usuário inserir o número do candidato deverá exibir a foto, nome do candidato, partido, número de candidatura.
![image](https://github.com/user-attachments/assets/2e75a9de-247f-464d-953d-9d5e0e4ff177)

Tela de Resultado ordenada de mais votado para menos votado
Limitação dos campos de cadastro a 15 caracteres para nome e partido, e 2 caracteres para o número do candidato, a foto deve ser usada uma foto local.
Controle de acesso de usuário/voto
Validação dos dados + tabela de usuarios

![image](https://github.com/user-attachments/assets/d6c3ef8b-fddd-4a92-9606-016e72f58c10)
Vice do candidato foi adicionado ao sistema. Deve ser incluido ao cadastrar o candidato, ao votar aparece os dados do candidato e do vice.
Campos validados e Testes realizados.

Pendente - Cargo eleitoral , porém é opcional para locais que não irá utilizar os cargos políticos como:
  Presidente e vice-presidente da República	
  Deputado federal/senador	
  Governador	
  Deputado estadual/distrital/de território	
  Prefeito, vice-prefeito e vereadores

Melhorias futuras:
  Melhorias de UIUX

Sugestão:
  atrelar a votação a blockchain para que qualquer mudança futura seja matematicamente improvável.

Essa aplicação pode ser aplicada em qualquer escola para votação de alunos, diretores, ou até mesmo personagens favoritos, a aplicação é livre.
Para aplicar no cenário real, o sistema deverá receber os dados de quem esta votando para evitar duplicidade de voto pela mesma pessoa.
Número de votos não deverá passar o número de pessoas existentes no ambiente (escola, sala, Brasil).

Em caso de sugestão abra um request, para sugerir uma melhoria.
