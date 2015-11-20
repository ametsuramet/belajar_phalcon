<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class ArticlesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for articles
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Articles", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $articles = Articles::find($parameters);
        if (count($articles) == 0) {
            $this->flash->notice("The search did not find any articles");

            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $articles,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a article
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $article = Articles::findFirstByid($id);
            if (!$article) {
                $this->flash->error("article was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "articles",
                    "action" => "index"
                ));
            }

            $this->view->id = $article->id;

            $this->tag->setDefault("id", $article->getId());
            $this->tag->setDefault("title", $article->getTitle());
            $this->tag->setDefault("category_id", $article->getCategoryId());
            $this->tag->setDefault("description", $article->getDescription());
            $this->tag->setDefault("images", $article->getImages());
            $this->tag->setDefault("status", $article->getStatus());
            
        }
    }

    /**
     * Creates a new article
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "index"
            ));
        }

        $article = new Articles();

        $article->setTitle($this->request->getPost("title"));
        $article->setCategoryId($this->request->getPost("category_id"));
        $article->setDescription($this->request->getPost("description"));
        $article->setImages($this->request->getPost("images"));
        $article->setStatus($this->request->getPost("status"));
        

        if (!$article->save()) {
            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "new"
            ));
        }

        $this->flash->success("article was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "articles",
            "action" => "index"
        ));

    }

    /**
     * Saves a article edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $article = Articles::findFirstByid($id);
        if (!$article) {
            $this->flash->error("article does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "index"
            ));
        }

        $article->setTitle($this->request->getPost("title"));
        $article->setCategoryId($this->request->getPost("category_id"));
        $article->setDescription($this->request->getPost("description"));
        $article->setImages($this->request->getPost("images"));
        $article->setStatus($this->request->getPost("status"));
        

        if (!$article->save()) {

            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "edit",
                "params" => array($article->id)
            ));
        }

        $this->flash->success("article was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "articles",
            "action" => "index"
        ));

    }

    /**
     * Deletes a article
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $article = Articles::findFirstByid($id);
        if (!$article) {
            $this->flash->error("article was not found");

            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "index"
            ));
        }

        if (!$article->delete()) {

            foreach ($article->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "articles",
                "action" => "search"
            ));
        }

        $this->flash->success("article was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "articles",
            "action" => "index"
        ));
    }

}
