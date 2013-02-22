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
class Post
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
    protected $title;

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
	 * The date and time that this post was created; if this post is a revision
	 * to an already existing post, this timestamp represents the date the post
	 * was last updated.
     * @var int
	 * @access protected
     */
    protected $timestamp;
	
	/**
	 * The status of the post.
	 * @var string
	 * @access protected
	 */
	protected $status;

	/**
	 * A summary of the post, in abstract.
	 * @var string
	 * @access protected
	 */
    protected $abstract;
	
	/**
	 * The content of the post, with markup.
	 * @var string
	 * @access protected
	 */
    protected $content;

    /**
	 * Comments made on this post.
     * @var array
	 * @access protected
     */
    protected $comments;
	
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
    protected $tags;

    public function __toString()
    {
      return $this->getTitle();
    }

    public function __construct()
    {
        $this->tags     = new \Doctrine\Common\Collections\ArrayCollection;
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection;
        $this->created_at = new \DateTime("now");;
    }
}