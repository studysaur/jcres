namespace Gen;

class DatabaseTable{
    private $pdo;
    private $table;
    private $primaryKey;
    private $className;
    private $constructorArgs;

    public function __construct(\PDO $pdo, $table, $primaryKey, $className = '\stdClass', $constructorArgs = [])

    public function total($field = null, $value = null)

    // $value is primary key
    public function findById($value)

    //Selects all, $column is what is searched, $value is value in column
    public function find($column, $value, $orderBy = null, $limit = null, $offset = null)

    // this is the primary key id
    public function delete($id)

    public function deleteWhere($column, $value)

    public function findAll($orderBy = null, $limit = null, $offset = null)

    public function save($record)