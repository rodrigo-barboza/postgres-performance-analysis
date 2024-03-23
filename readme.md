# PostgreSQL Performance Analysis

Programa sintético em PHP para análise de desempenho do banco de dados PostgreSQL nas operações de insert, update e select.

## Requisitos

- PHP 8.2 (ou superior)
- PostgreSQL 16
- Extensão `pdo_pgsql` habilitada

## Instalação do PHP
O ambiente que utilizei foi o windows 10 com o XAMPP (que já vem com o PHP).

### No Windows:

1.  **Usando o Instalador do PHP para Windows:**
    
    -   Baixe o instalador mais recente do PHP para Windows no site oficial do PHP ([https://windows.php.net/download/](https://windows.php.net/download/)).
    -   Execute o arquivo do instalador baixado e siga as instruções na tela.
    -   Durante o processo de instalação, você terá a opção de configurar o PHP para ser executado como CGI, como módulo do servidor (por exemplo, Apache) ou para uso em linha de comando. Escolha a opção que melhor atenda às suas necessidades.
    -   Se necessário, configure o PHP no servidor web (por exemplo, Apache) seguindo as instruções de configuração específicas do servidor.
2.  **Usando o XAMPP ou WAMP:**
    
    -   Você também pode instalar o PHP como parte de um pacote de software que inclui um servidor web, como o XAMPP (https://www.apachefriends.org/index.html) ou o WAMP (http://www.wampserver.com/en/).
    -   Baixe e instale o XAMPP ou WAMP de acordo com as instruções fornecidas em seus respectivos sites.
    -   O PHP estará incluído e configurado automaticamente como parte do pacote de software.
### No Linux:

1.  **Usando o Gerenciador de Pacotes:**
    
    -   No Ubuntu e outras distribuições baseadas em Debian, você pode instalar o PHP usando o apt-get:
        
 
        ```bash
        sudo apt-get update
        sudo apt-get install php 
        ````
    -   Em distribuições baseadas no Red Hat, como CentOS e Fedora, você pode usar o yum:
        
         ```bash
        sudo yum install php` 
        ```
2.  **Instalação Manual:**
    
    -   Você também pode compilar e instalar o PHP manualmente a partir do código-fonte. Isso geralmente é mais complexo e requer conhecimentos avançados do sistema. Você pode encontrar instruções detalhadas no site oficial do PHP ([https://www.php.net/manual/en/install.php](https://www.php.net/manual/en/install.php)).

Após a instalação, você pode testar se o PHP está funcionando corretamente executando o seguinte comando no terminal ou prompt de comando:

 ```bash
php -v
```

Isso exibirá a versão do PHP instalada e confirmará se o PHP foi instalado corretamente.
## Habilitar a extensão no php.ini

Para habilitar a extensão PDO_PGSQL no PHP, siga estas etapas:

1.  Localize o arquivo de configuração php.ini em seu sistema. Dependendo da instalação do PHP e do sistema operacional, o php.ini pode estar em locais diferentes. Você pode usar o seguinte comando no terminal ou prompt de comando para encontrar o local do php.ini:
    
```bash
php --ini
```    
  Isso mostrará o caminho do arquivo php.ini em uso.
    
2.  Abra o arquivo php.ini em um editor de texto.
    
3.  Procure pela linha que contém a diretiva `;extension=pdo_pgsql`. Esta linha pode estar comentada (iniciando com `;`) por padrão.
    
4.  Remova o ponto e vírgula (`;`) do início da linha para descomentá-la e habilitar a extensão. A linha deve ficar assim:
    
```bash
extension=pdo_pgsql
```
5.  Salve o arquivo php.ini e feche o editor de texto.
    
6.  Reinicie o servidor web ou o serviço PHP-FPM para aplicar as alterações. O comando específico para reiniciar o servidor web ou PHP-FPM depende do seu sistema operacional e do servidor web que você está usando. Aqui estão alguns exemplos:
    
   -   No Linux com Apache:
        
```bash 
sudo systemctl restart apache2
``` 
   - No Linux com Nginx e PHP-FPM:
        
```bash 
sudo systemctl restart php-fpm
sudo systemctl restart nginx` 
 ```
   -   No Windows com Apache ou Nginx: Reinicie o serviço correspondente via interface gráfica ou utilizando o Gerenciador de Serviços do Windows.
        

Após seguir esses passos, a extensão PDO_PGSQL estará habilitada e pronta para ser usada em seus scripts PHP. Você pode verificar se a extensão está habilitada usando a função `phpinfo()` ou executando o seguinte comando no terminal ou prompt de comando:

```bash
php -m | grep pdo_pgsql
```

Isso deve retornar `pdo_pgsql` se a extensão estiver habilitada corretamente.

## Instalar o PostgreSQL 16

### No Windows:

1.  **Usando o Instalador do PostgreSQL:**
    
    -   Baixe o instalador mais recente do PostgreSQL para Windows no site oficial ([https://www.postgresql.org/download/windows/](https://www.postgresql.org/download/windows/)).
    -   Execute o instalador baixado e siga as instruções na tela. Durante o processo de instalação, você poderá escolher a pasta de instalação, a senha do superusuário (postgres), e outras opções de configuração.
    -   Após a conclusão da instalação, você pode encontrar o PostgreSQL no menu Iniciar e executar o aplicativo pgAdmin, uma ferramenta gráfica para gerenciar o PostgreSQL.

### No Linux:

1.  **Usando o Gerenciador de Pacotes:**
    
   -   No Ubuntu e outras distribuições baseadas em Debian, você pode instalar o PostgreSQL usando o apt-get:
        
```bash 
sudo apt-get update
sudo apt-get install postgresql
```
   -   Em distribuições baseadas no Red Hat, como CentOS e Fedora, você pode usar o yum:
        
```bash  
 sudo yum install postgresql-server
 ```
   -   Após a instalação, o PostgreSQL estará instalado e será executado como um serviço. Você pode gerenciar o serviço PostgreSQL usando os comandos do systemd (systemctl).
        
2.  **Configuração Inicial:**
    
    -   Após a instalação, você pode precisar inicializar o banco de dados e configurar a senha do superusuário (postgres). Para fazer isso, execute os seguintes comandos:
        
```bash         
sudo postgresql-setup initdb   # Inicializa o banco de dados
sudo systemctl start postgresql   # Inicia o serviço PostgreSQL
sudo systemctl enable postgresql   # Habilita o serviço para iniciar automaticamente na inicialização
sudo -u postgres psql   # Conecta ao banco de dados como o usuário postgres` 
```        
Dentro do console do PostgreSQL, você pode definir a senha do superusuário usando o comando:
        
```bash
ALTER USER postgres WITH PASSWORD 'nova_senha';` 
```        
Substitua `'nova_senha'` pela senha desejada.

Após a instalação e configuração, você poderá se conectar ao PostgreSQL usando um cliente SQL, como o psql (linha de comando) ou o pgAdmin (interface gráfica).

## Configurando a conexão

Para que tudo funcione corretamente, você deve atualizar o arquivo `config.php` com suas credenciais de conexão, bem como atualizar o nome da base de dados (se desejar):
```php
function  connections(): array
{
	return [
		'pgsql' => [
			'driver' => 'pgsql',
			'host' => 'localhost',
			'port' => '5432',
			'database' => 'ads_pgsql_php',
			'username' => 'postgres',
			'password' => '12345',
			'dsn' => 'pgsql:host=localhost;dbname=ads_pgsql_php',
		],
	];
}
```
O driver não deve ser alterado. O host, port, deve ser alterado caso a configuração da sua máquina seja diferente das configurações padrões do Postgres. Database deve ser alterado se desejar alterar o nome da base de dados, caso contrário basta criar a base de dados `'ads_pgsql_php'`, username e password devem corresponder às credenciais que você configurou na etapa de instalação do Postgres.

## Executando o programa

Se você realizou todos os passos anteriores corretamente, basta ir na pasta raíz do projeto pelo terminal e executar:
```bash
php index.php
``` 
A saída deverá ser como:
```bash
Criando banco de dados e tabela...
Banco de dados e tabela criados.

Iniciando: inserts...
Finalizado(inserts). Em: 185.6509 s

Iniciando: updates...
Finalizado(updates). Em: 214.3559 s

Finalizado(selects). Em: 126.1963 s
```
O programa pode ser executado quantas vezes se desejar. A tabela sempre será dropada no início da execução do programa, então não haverá acumulação de dados de uma execução para a outra. Além disso, os dados do arquivo out.csv serão sobrescritos à cada execução, portanto se desejar salvar a saída, basta renomear o arquivo antes de executar novamente.