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
namespace Rhapsody\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 *
 * @author Sean.Quinn
 *
 */
class BlogController extends Controller
{


	/**
	 *
	 */
	public function archiveAction()
	{
		// /** @var $templateManager \Rhapsody\CommonsBundle\TemplateManager */
		// $templateManager = $this->get('rhapsody.commons.template_manager');


		$data = array();
		return $this->render('RhapsodyBlogBundle:Blog:archive.html.twig', $data);
	}

	/**
	 *
	 */
	public function commentAction()
	{

	}

	/**
	 *
	 */
	public function commentsAction()
	{
		$data = array();
		return $this->render('RhapsodyBlogBundle:Blog:comments.html.twig', $data);
	}

	/**
	 * <p>
	 * Renders a digest of posts with a given <tt>$tag</tt> (optional).
	 * </p>
	 */
	public function digestAction()
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();

		/** @var $postManager \Rhapsody\BlogBundle\Doctrine\PostManager */
		$postManager = $this->get('rhapsody_blog.post_manager');

		$tag = $request->get('tag', null);
		$offset = $request->get('offset', 0);
		$show = $request->get('show', 10);
		$posts = $postManager->findAll(array('tag' => $tag, 'limit' => $show));

		$data = array('offset' => $offset, 'posts' => $posts, 'show' => $show, 'tag'   => $tag);
		return $this->render('RhapsodyBlogBundle:Blog:digest.html.twig', $data);
	}

	/**
	 *
	 */
	public function feedAction()
	{

	}

	public function indexAction()
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();

		/** @var $postManager \Rhapsody\BlogBundle\Doctrine\PostManager */
		$postManager = $this->get('rhapsody_blog.post_manager');

		$posts = $postManager->findAll();

		$data = array('posts' => $posts);
		return $this->render('RhapsodyBlogBundle:Blog:index.html.twig', $data);
	}

	/**
	 *
	 */
	public function readAction()
	{
		/** @var $request \Symfony\Component\HttpFoundation\Request */
		$request = $this->getRequest();

		/** @var $postManager \Rhapsody\BlogBundle\Doctrine\PostManager */
		$postManager = $this->get('rhapsody_blog.post_manager');

		$slug = $request->get('slug');
		$post = $postManager->getPostBySlug($slug);
		$prevPost = $postManager->getPreviousPost($post);
		$nextPost = $postManager->getNextPost($post);

		$data = array('post' => $post, 'previous' => $prevPost, 'next' => $nextPost);
		return $this->render('RhapsodyBlogBundle:Blog:post.html.twig', $data);
	}

	/**
	 *
	 */
	public function tagsAction()
	{

	}
}