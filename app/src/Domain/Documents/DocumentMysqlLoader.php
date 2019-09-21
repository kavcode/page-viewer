<?php declare(strict_types=1);

namespace App\Domain\Documents;

use App\Markdown\Parser;

class DocumentMysqlLoader implements DocumentRepositoryInterface
{
    private $dsn;
    private $user;
    private $password;
    private $parser;

    private $connection;

    public function __construct(
        string $dsn,
        string $user,
        string $password,
        Parser $parser
    )
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        $this->parser = $parser;
    }


    public function findAll(): array
    {
        $stmt = $this->getConnection()
            ->prepare(
                'SELECT link.link, page.title, page.mime, page.text FROM link INNER JOIN page ON link.page_id = page.id'
            );

        $result = $stmt->execute();
        if (!$result) {
            throw new \RuntimeException($this->getConnection()->errorInfo());
        }

        $data = [];
        foreach ($stmt->fetchAll() as $row) {
            $data[] = $this->createDocument(
                $row['title'],
                $row['link'],
                $row['text'],
                $row['mime']
            );
        }

        return $data;
    }

    public function findByName(string $pattern): array
    {
        $stmt = $this->getConnection()
            ->prepare(
                "SELECT link.link, page.title, page.mime, page.text FROM link INNER JOIN page ON link.page_id = page.id WHERE page.title LIKE :pattern"
            );
        $value = "%{$pattern}%";
        $stmt->bindParam('pattern', $value);
        $result = $stmt->execute();
        if (!$result) {
            throw new \RuntimeException($this->getConnection()->errorInfo());
        }

        $data = [];
        foreach ($stmt->fetchAll() as $row) {
            $data[] = $this->createDocument(
                $row['title'],
                $row['link'],
                $row['text'],
                $row['mime']
            );
        }

        return $data;
    }

    public function findByLink(string $link): ?Document
    {
        $stmt = $this->getConnection()
            ->prepare(
                'SELECT link.link, page.title, page.mime, page.text FROM link INNER JOIN page ON link.page_id = page.id WHERE link = :link'
            );
        $stmt->bindParam('link', $link);
        $result = $stmt->execute();
        if (!$result) {
            throw new \RuntimeException($this->getConnection()->errorInfo());
        }

        $data = $stmt->fetchAll();

        return isset($data[0])
            ? $this->createDocument($data[0]['title'], $data[0]['link'], $data[0]['text'], $data[0]['mime'])
            : null;
    }

    private function getConnection()
    {
        if ($this->connection === null) {
            $this->connection = new \PDO($this->dsn, $this->user, $this->password);
        }

        return $this->connection;
    }

    private function createDocument(
        string $title,
        string $link,
        string $text,
        string $mime
    ) : Document
    {
        return new Document(
            $title,
            $link,
            $mime === 'text/plain'
                ? $this->parser->parseFromLineArray(preg_split('/\n/m', $text))->getHtml()
                : $text
        );
    }
}