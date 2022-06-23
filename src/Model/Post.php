<?php

namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post 
{
    private $id;
    private $slug;
    private $name;
    private $content;
    private $created_at;
    private $categories = [];

    /**
     * Get the value of name
     */ 
    public function getName() : ?string
    {
        return $this->name;
    }

    public function getExcerpt (): ?string
    {
        if ($this->content === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }    

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Get the value of id
     */ 
    public function getId() : ?int
    {
        return $this->id;
    }

    /**
     * Get the value of content
     */ 
    public function getFormattedContent()
    {
        return nl2br(e($this->content)) ;
    }
}
