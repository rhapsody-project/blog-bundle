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
namespace Rhapsody\BlogBundle\Twig\Extension;

use Doctrine\Common\Util\Debug;
use Rhapsody\BlogBundle\Model\PostInterface;
use Rhapsody\BlogBundle\Model\PostPreview;
use Rhapsody\CommonsBundle\Model\MarkupProcessor;
use Rhapsody\CommonsBundle\Twig\TwigTemplateManager;

/**
 * <p>
 * A Twig extension for the Rhapsody BlogBundle.
 * </p>
 *
 * @author Sean W. Quinn
 */
class RhapsodyBlogExtension extends \Twig_Extension
{
	/**
	 * A "read more" regex, used by blog systems like WordPress to enable the
	 * author to make a cut to content for the preview manually and to attribute
	 * a specific tag used for the read more link.
	 */
	const READ_MORE_REGEX = '<!--\s*more\s*(\[.*\])?\s*-->';

	/**
	 *
	 * @var Rhapsody\CommonsBundle\Model\MarkupProcessor
	 * @access protected
	 */
	protected $markupProcessor;

	/**
	 * The template manager.
	 * @var Rhapsody\CommonsBundle\Twig\TwigTemplateManager
	 * @access protected
	 */
	protected $templateManager;

	public function __construct(TwigTemplateManager $templateManager, MarkupProcessor $markupProcessor)
	{
		$this->templateManager = $templateManager;
		$this->markupProcessor = $markupProcessor;
	}

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
    	$functions = array();

    	$functions['post_preview'] = new \Twig_Function_Method($this, 'renderPostPreview', array('is_safe' => array('html')));
    	$functions['blog_widget']  = new \Twig_Function_Method($this, 'renderBlogWidget', array('is_safe' => array('html')));
		return $functions;
    }

    /**
     * Returns the text that will be used for the preview of the blog post.
     * @param PostInterface $post
     * @return string
     */
    private function getPostPreview(PostInterface $post)
    {
    	$text = $post->getText();
    	$regex = '/'.RhapsodyBlogExtension::READ_MORE_REGEX.'/ix';
    	if (preg_match($regex, $text, $matches)) {
    		$more = $matches[0];
    		$parts = preg_split($regex, $text);

    		$postPreview = new PostPreview($post, $parts[0], $more);
    		return $postPreview;
    	}

    	$cutoff = strlen($text) > 250 ? 250 : strlen($text);
    	return new PostPreview($post, substr($text, 0, $cutoff));
    }

    /**
	 * <p>
	 * Renders blog widgets (e.g. posts, comments).
	 * </p>
	 *
	 * @param mixed $widget the widget to be rendered.
	 * @param array $options the options passed to be considered when rendering.
     */
    public function renderBlogWidget($widget, array $options = array())
    {
    	$className = get_class($widget);
    	$class = new \ReflectionClass($className);

    	if ($class->implementsInterface('Rhapsody\BlogBundle\Model\PostInterface')) {
    		return $this->renderPostWidget($widget);
    	}
    	else if ($class->implementsInterface('Rhapsody\BlogBundle\Model\CommentInterface')) {
    		return $this->renderCommentWidget($widget);
    	}
    }

    protected function renderCommentWidget(CommentInterface $comment)
    {
		return $templateManager->render($comment);
    }

    /**
     */
    public function renderPostPreview(PostInterface $post)
    {
		$postPreview = $this->getPostPreview($post);
		return $this->templateManager->render($postPreview);
    }

    /**
     * Renders the post preview.
     * @param PostInterface $post
     */
    protected function renderPostWidget(PostInterface $post)
    {
    	return $this->templateManager->render($post);
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name.
     */
    public function getName()
    {
        return 'rhapsody_blog';
    }

    /**
     * Check or text has the "more" tag (e.g. <tt>&lt;--more--></tt>).
     *
     * @param string $value The full source text, not marked up.
     * @return boolean <tt>true</tt> if the read more tag is found, false
     * 		otherwise.
     */
    public function hasMoreTag($value)
    {
    	$regex = '/'.RhapsodyBlogExtension::READ_MORE_REGEX . '/ix';
    	return preg_match($regex, $value) > 0;
    }
}