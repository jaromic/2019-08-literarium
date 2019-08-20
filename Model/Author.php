<?php


class Author
{
    private $id;
    private $firstname;
    private $lastname;
    private static $highestId = 0;

    /**
     * Author constructor.
     * @param $firstname
     * @param $lastname
     */
    public function __construct($firstname, $lastname)
    {
        $this->id = isset($_SESSION['highest_id']) ? $_SESSION['highest_id'] : 0;
        $_SESSION['highest_id'] = $this->id + 1;

        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return Author[]
     */
    public static function findAll()
    {
        $authors = [];

        foreach ($_SESSION['author'] as $authorSerialized) {
            array_push($authors, unserialize($authorSerialized));
        }

        return $authors;
    }

    /**
     * @param int $id
     * @return Author
     */
    public static function find(int $id)
    {
        if (isset($_SESSION['author'][$id])) {
            return unserialize($_SESSION['author'][$id]);
        } else {
            return null;
        }
    }

    /**
     *
     */
    public function save()
    {
        $_SESSION['author'][$this->id] = serialize($this);
    }

    public function delete()
    {
        if (isset($_SESSION['author'][$this->id])) {
            unset ($_SESSION['author'][$this->id]);
        }
    }

    /**
     * @return int
     */
    public
    function getId(): int
    {
        return $this->id;
    }

}