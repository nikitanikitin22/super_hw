<?php

declare(strict_types=1);

namespace Super\Mapper;

use Super\Entity\Post;

class PostMapper
{
    public function map(array $post)
    {
        return new Post(
            $post['id'],
            $post['from_name'],
            $post['from_id'],
            $post['message'],
            $post['type'],
            \DateTimeImmutable::createFromFormat(DATE_ATOM, $post['created_time'])
        );
    }
}
