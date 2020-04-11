<strong>O problema da rota de viagem, que visa pagar o menor preço possível, é muito similar ao problema do caminho mais curto em um grafo dirigido ou não dirigido. Para solucionar esse problema, o algoritmo de Edsger Dijkstra (1956) serve como base nessa implementação.</strong>  

<h2>Instruções para executar a aplicação</h2>  

1- Certifique-se de ter instalado o PHP ˆ7.2 e o gerenciador de pacotes composer  

2- Clonar o repositório, ir até a raiz do projeto pelo terminal e rodar: <strong>composer install</strong> para instalar os pacotes necessários  

<h3>Interface de Console</h3>  

1- Para rodar a interface de console, na raiz do projeto deve-se rodar o comando: <strong>php artisan find:shortest-path diretorio/para/input.csv</strong>  

2- A rota com o melhor caminho a ser encontrado, deve ser passada no formato: <strong>GRU-CDG</strong>
  
3- Caso não seja passado o parâmetro para o diretório, o comando usará o input.csv default encontrado em <strong>assets/input.csv</strong>
  
4- Lembrando que caso o parâmetro seja passado, o sistema usa a raiz do projeto como base, portanto se o arquivo de input estiver fora da raiz do projeto, deve-se indicar a saída como em: <strong>../../users/path/input.csv</strong>  

<h3>Interface Rest</h3>

1 - Foram criadas duas rotas, uma GET para consulta de melhor rota entre dois pontos e uma POST que fará o registro de novas rotas. As rotas podem ser encontradas em <strong>routes/api.php</strong>:
<strong>
 - GET /shortest-path
 - POST /shortest-path 
 </strong>
 
2- Para ser possível testa-las, será necessário iniciar o servidor php de desenvolvimento através do comando <strong>php artisan serve</strong> (por padrão será usada a porta 8000)  

3- Para agilizar os testes, eu exportei uma collection contendo os endpoints usados na API. Essa collection deve ser importada pelo Postman e está na raiz do projeto <strong>Shortest_Path.postman_collection.json</strong>  

4- Ambos endpoints suportam os campos <strong>route</strong> e <strong>file</strong> que devem ser enviados no body da requisição, ou via query string.  

- route: no endpoint GET, esse campo é obrigatório e representa a rota cujo melhor caminho deve ser encontrado, deve ser enviado seguindo o formato: <strong>GRU-CDG</strong>. Já no POST, será a rota e a distância a ser inserida no arquivo .csv de entrada, deve ser enviado no formato: <strong>GRU,CDG,20</strong>  
- file: em ambos endpoints é um campo opcional e representa o diretório para o arquivo csv de entrada. Caso não seja informado, será usado o arquivo input default, encontrado em <strong>assets/input.csv</strong>. Lembrando que a mesma consideração (Interface de Console - 4) se aplica caso o arquivo esteja fora da raiz do projeto.

<h3>Testes de Unidade</h3>  

1- Foram criados alguns testes de unidade para garantir o bom funcionamento do código. Os testes podem ser encontrados em: <strong>tests/Unit/</strong> e para rodá-los, execute o comando: <strong>./vendor/bin/phpunit</strong>  
