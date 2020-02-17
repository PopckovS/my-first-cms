<?php


/**
 * Класс для обработки статей
 */
class Users
{
    // Свойства
    /**
    * @var int ID пользвателя из базы данны
    */
    public $id = null;

    /**
    * @var string логин
    */
    public $login = null;

    /**
    * @var string Hпароль
    */
    public $password = null;
    
    
    /**
    * @var string состояние
    */
    public $active = null;
    
    
    
    /**
    * Устанавливаем свойства с помощью значений в заданном массиве
    *
    * @param assoc Значения свойств
    */

    /**
     * Создаст объект статьи
     * 
     * @param array $data массив значений (столбцов) строки таблицы статей
     */
    public function __construct($data=array())
    {
        
      if (isset($data['id'])) {
          $this->id = (int) $data['id'];
      }
      
      if (isset($data['login'])) {
          $this->login = $data['login'];         
      }
      
      if (isset($data['password'])) {
          $this->password = $data['password'];  
      }
      
       if (isset($data['active'])) {
          $this->active = (int) $data['active'];  
      }

    }


    /**
    * Устанавливаем свойства с помощью значений формы редактирования записи в заданном массиве
    *
    * @param assoc Значения записи формы
    */
    public function storeFormValues ( $params ) {

      // Сохраняем все параметры
      $this->__construct( $params );
    }


    /**
    * Возвращаем объект статьи соответствующий заданному ID статьи
    *
    * @param int ID статьи
    * @return Article|false Объект статьи или false, если запи  сь не найдена или возникли проблемы
    */
    public static function getById($id) {
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "SELECT * FROM users WHERE id = :id";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();

        $row = $st->fetch();
        $conn = null;

        if ($row) { 
            return new Users($row);
        }
    }




    /**
    * Возвращает все (или диапазон) объекты Article из базы данных
    *
    * @param int $numRows Количество возвращаемых строк (по умолчанию = 1000000)
    * @param int $categoryId Вернуть статьи только из категории с указанным ID
    * @param string $order Столбец, по которому выполняется сортировка статей (по умолчанию = "publicationDate DESC")
    * @return Array|false Двух элементный массив: results => массив объектов Article; totalRows => общее количество строк
    */
   public static function getAllUsers($numRows = 1000000) 
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);

        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users LIMIT :numRows";
         
        $st = $conn->prepare($sql);

       // trace($st);

        //Здесь $st - текст предполагаемого SQL-запроса, причём переменные не отображаются
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        
        $st->execute(); // выполняем запрос к базе данных

       // trace($st);

        $list = array();

        while ($row = $st->fetch()) 
        {
        	$user = new Users($row);	
            $users[] = $user;
        }
        
       //trace($list);
         
        // Получаем общее количество статей, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();
        $conn = null;
        
        return ( ["results" => $users, "totalRows" => $totalRows[0]] );
    }




    /**
    * Вставляем текущий объект статьи в базу данных, устанавливаем его свойства.
    */


    /**
    * Вставляем текущий объек Article в базу данных, устанавливаем его ID.
    */
    public function insert() 
    {
    	$this->password = password_hash($this->password, PASSWORD_DEFAULT);
        
        //trace($this);
        //die();
        // Есть уже у объекта Article ID?
        if ( !is_null( $this->id ) and ($this->id != 0 ) ) 
        {
            trigger_error ( "Users::insert(): Attempt to insert an Users object that already has its ID property set (to $thiss->id).", E_USER_ERROR );
	}

        // Вставляем статью
        $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
        $sql = "INSERT INTO users ( login, password, active ) VALUES ( :login, :password, :active )";
        $st = $conn->prepare ( $sql );
        $st->bindValue( ":login", $this->login, PDO::PARAM_STR );
        $st->bindValue( ":password", $this->password, PDO::PARAM_STR );
        $st->bindValue( ":active", $this->active, PDO::PARAM_INT );
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }


    /**
    * Обновляем текущий объект статьи в базе данных
    */
    public function update() 
    {
       
      // Есть ли у объекта статьи ID?
      if ( is_null( $this->id ) ) 
      {
      	trigger_error ( "Users::update(): " . "Attempt to update an Users object ". "that does not have its ID property set.", E_USER_ERROR );
      }

      
      // Обновляем статью
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      /* 
      $sql = "UPDATE users SET publicationDate = FROM_UNIXTIME(:publicationDate),"
              . " categoryId=:categoryId, title=:title, summary=:summary,"
              . " content=:content, active=:active WHERE id = :id";
      */
      $sql = "UPDATE users SET login=:login, password=:password, active=:active WHERE id = :id";
      
      $st = $conn->prepare ( $sql );
      $st->bindValue( ":login", $this->login, PDO::PARAM_STR );
      $st->bindValue( ":password", $this->password, PDO::PARAM_STR );
      $st->bindValue( ":active", $this->active, PDO::PARAM_INT );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }


    /**
    * Удаляем текущий объект статьи из базы данных
    */
    public function delete() {

      // Есть ли у объекта статьи ID?
      if ( is_null( $this->id ) ) 
      {
      	 trigger_error ( "Users::delete(): Attempt to delete an Users object that does not have its ID property set.", E_USER_ERROR );
      }

      // Удаляем юзера
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
      $st = $conn->prepare ( "DELETE FROM users WHERE id = :id LIMIT 1" );
      $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
      $st->execute();
      $conn = null;
    }

}
