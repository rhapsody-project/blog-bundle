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
namespace Rhapsody\BlogBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Rhapsody\BlogBundle\Model\PostInterface;
use Rhapsody\BlogBundle\Model\PostManager as BasePostManager;

class PostManager extends BasePostManager
{
	/**
	 *
	 * @var $objectManager \Doctrine\Common\Persistence\ObjectManager
	 */
	protected $objectManager;

	/**
	 *
	 * @var $class string
	 */
	protected $class;

	/**
	 * @var $repository \Rhapsody\BlogBundle\Repository\PostRepositoryInterface
	 */
	protected $repository;

	/**
	 * Constructor.
	 *
	 * @param EncoderFactoryInterface $encoderFactory
	 * @param CanonicalizerInterface  $usernameCanonicalizer
	 * @param CanonicalizerInterface  $emailCanonicalizer
	 * @param ObjectManager           $om
	 * @param string                  $class
	 */
	public function __construct(ObjectManager $objectManager, $class)
	{
		$this->objectManager = $objectManager;
		$this->repository = $objectManager->getRepository($class);

		$metadata = $objectManager->getClassMetadata($class);
		$this->class = $metadata->getName();
	}

	/**
	 * Finds all of the posts
	 * @param array $options
	 */
	public function findAll(array $options = array())
	{
		$options = array_merge(array('limit' => $this->limit), $options);
		$posts = $this->repository->search($options);
		return $posts;
	}

	/**
	 *
	 * @param unknown $slug
	 * @return unknown
	 */
	public function getPostBySlug($slug)
	{
		$post = $this->repository->findOneBySlug($slug);
		return $post;
	}

	/**
	 *
	 * @param PostInterface $post
	 * @throws \Exception
	 */
	public function getPreviousPost(PostInterface $post)
	{
		//throw new \Exception('implement me');
		return null;
	}

	/**
	 *
	 * @param PostInterface $post
	 * @throws \Exception
	 */
	public function getNextPost(PostInterface $post)
	{
		//throw new \Exception('implement me');
		return null;
	}
}