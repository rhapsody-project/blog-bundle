<?php
/* Copyright (c) 2013 Rhapsody Project
 *
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 *
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
 * KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Rhapsody\BlogBundle\Model;

/**
 *
 * @author 	  Sean W. Quinn
 * @category  Rhapsody BlogBundle
 * @package   Rhapsody\Blogundle\Model
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class Post implements PostInterface
{

	/**
	 * The identifier for this post.
	 * @var mixed
	 * @access protected
	 */
    protected $id;

	/**
	 * The version identifier of this post.
	 * @var mixed
	 * @access protected
	 */
	protected $version;

	/**
	 * The title of this post.
	 * @var string
	 * @access protected
	 */
    protected $title = '';

	/**
	 * The slug for this post.
	 * @var string
	 * @access protected
	 */
	protected $slug;

	/**
	 * The user who authored the post.
	 * @var mixed
	 * @access protected
	 */
	protected $author;

	/**
	 * The parent post; if null this post represents the first post in a
	 * possible collection of post revisions.
	 * @var \Rhapsody\BlogBundle\Model\PostInterface
	 * @access protected
	 */
	protected $parent;

    /**
	 * The date and time that this post was created; if this post is a revision
	 * to an already existing post, this timestamp represents the date the post
	 * was last updated.
     * @var \DateTime
	 * @access protected
     */
    protected $date;

	/**
	 * The status of the post.
	 * @var string
	 * @access protected
	 */
	protected $status;

	/**
	 * The content of the post, with markup.
	 * @var string
	 * @access protected
	 */
    protected $text;

    /**
	 * Comments made on this post.
     * @var array
	 * @access protected
     */
    protected $comments = array();

	/**
	 * The revision history of this post.
	 * @var array
	 * @access protected
	 */
	protected $revisions;

    /**
	 * Tags on this post.
     * @var array
	 * @access protected
     */
    protected $tags = array();

    /**
     *
     */
    public function __toString()
    {
      return $this->getTitle();
    }

    /**
     *
     */
    public function __construct()
    {
        $this->date = new \DateTime("now");
    }

    public function getAuthor()
    {
    	return $this->author;
    }

    /**
     *
     * @return array
     */
    public function getComments()
    {
    	return $this->comments;
    }

    public function getParent()
    {
    	return $this->parent;
    }

    public function getText()
    {
    	return $this->text;
    }

    public function getId()
    {
    	return $this->id;
    }

    public function getRevisions()
    {
    	return $this->revisions;
    }

    public function getSlug()
    {
    	return $this->slug;
    }

    public function getStatus()
    {
    	return $this->status;
    }

    public function getTags()
    {
    	return $this->tags;
    }

    public function getDate()
    {
    	return $this->date;
    }

    public function getTitle()
    {
    	return $this->title;
    }

    public function getVersion()
    {
    	return $this->version;
    }

    public function setAuthor($author)
    {
    	$this->author = $author;
    }

    /**
     *
     * @var array
     */
    public function setComments($comments)
    {
    	$this->comments = $comments;
    }

    public function setContent($content)
    {
    	$this->content = $content;
    }

    public function setId($id)
    {
    	$this->id = $id;
    }

    public function setParent(PostInterface $parent)
    {
    	$this->parent = $parent;
    }

    public function setRevisions($revisions)
    {
    	$this->revisions = $revisions;
    }

    public function setSlug($slug)
    {
    	$this->slug = $slug;
    }

    public function setStatus($status)
    {
    	$this->status = $status;
    }

    public function setTags($tags)
    {
    	$this->tags = $tags;
    }

    public function setDate($date)
    {
    	$this->date = $date;
    }

    public function setTitle($title)
    {
    	$this->title = $title;
    }

    public function setVersion($version)
    {
    	$this->version = $version;
    }
}