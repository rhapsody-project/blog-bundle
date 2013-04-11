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
namespace Rhapsody\BlogBundle\Repository\ODM;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Rhapsody\BlogBundle\Model\PostInterface;
use Rhapsody\BlogBundle\Repository\PostRepositoryInterface;

/**
 *
 * @author 	  Sean W. Quinn
 * @category  Rhapsody BlogBundle
 * @package   Rhapsody\Blogundle\Repository
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class PostRepository extends DocumentRepository implements PostRepositoryInterface
{

	/**
	 *
	 * @var array
	 */
	protected $defaultOptions = array(
		'tag' => null,
		'status' => PostInterface::POST_STATUS_PUBLISHED
	);

	/**
	 *
	 * @return array
	 */
	protected function getDateMapReduce()
	{
		$mapReduce = array();
		$mapReduce['map'] = 'function() { emit(this.slug, { "post": this }); }';
		$mapReduce['reduce'] = 'function(keys, values) {
			var challenge, latest = null;
			for (var i in values) {
				challenge = values[i];
				if (!latest) {
					latest = challenge;
				}
				else {
					if (latest.slug !== chalenge.slug) {
						return null;
					}

					if (challenge.date > latest.date) {
						latest = challenge;
					}
				}
			}
			return latest;
		}';
		return $mapReduce;
	}

	protected function getSearchQuery(array $options = array())
	{
		/** @var $qb \Doctrine\MongoDB\Query\Builder */
		$qb = $this->createQueryBuilder();

		$func = $this->getDateMapReduce();
		$options = array_merge($this->defaultOptions, $options);
		if (!empty($options['tag'])) {
			$qb->field('tags')->in($options['tags']);
		}

		if (!empty($options['status'])) {
			$qb->field('status')->equals($options['status']);
		}

		$qb->mapReduce($func['map'], $func['reduce']);
		$qb->sort('date', 'desc');
		return $qb->getQuery();
	}

	/**
	 *
	 * @param array $options
	 * @return Ambigous <\Doctrine\ODM\MongoDB\Query\mixed, \Doctrine\MongoDB\EagerCursor, object, \Doctrine\MongoDB\Cursor, Cursor, unknown, boolean, multitype:, \Doctrine\MongoDB\ArrayIterator, NULL, number>
	 */
	public function search(array $options = array())
	{
		$query = $this->getSearchQuery($options);
		$results = $query->execute();

		$posts = array();
		foreach ($results as $result) {
			$data = $result['value']['post'];
			$posts[] = $this->hydrate($data);
		}
		return $posts;
	}

	/**
	 * {@inheritDoc}
	 * <p>
	 * Uses MapReduce to find the post entry with the most recent timestamp.
	 * </p>
	 *
	 * @param unknown $slug
	 * @return object
	 */
	public function findOneBySlug($slug, array $optional = array())
	{
		$mapReduce = $this->getDateMapReduce();

		$qb = $this->createQueryBuilder();

		$qb->field('slug')->equals($slug);
		foreach ($optional as $field => $value) {
			$qb->field($field)->equals($value);
		}
		$qb->mapReduce($mapReduce['map'], $mapReduce['reduce']);
		$qb->sort('date', 'desc');
		$qb->limit(1);

		$query = $qb->getQuery();
		$result = $query->getSingleResult();
		$data = $result['value']['post'];
		return $this->hydrate($data);
	}

	/**
	 *
	 * @param unknown $data
	 * @return unknown
	 */
	private function hydrate($data)
	{
		$hydrator = $this->getDocumentManager()->getHydratorFactory();
		$class = $this->getClassName();

		$post = new $class;
		$hydrator->hydrate($post, $data);
		return $post;
	}
}