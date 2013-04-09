<?php
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