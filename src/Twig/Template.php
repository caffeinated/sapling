<?php
namespace Caffeinated\Sapling\Twig;

use Illuminate\View\View;
use Twig_Template;

abstract class Template extends Twig_Template
{
	/**
	 * @var bool
	 */
	protected $firedEvents = false;

	/**
	 * @var string
	 */
	protected $name = null;

	/**
	 * Displays the template with the given context.
	 *
	 * @param array $context An array of parameters to pass to the template
	 * @param array $blocks  An array of blocks to pass to the template
	 */
	public function display(array $context, array $blocks = array())
	{
		if ($this->shouldFireEvents()) {
			$context = $this->fireEvents($context);
		}

		parent::display($context, $blocks);
	}

	/**
	 * Fire off events.
	 *
	 * @param  array  $context  An array of parameters to pass to the template
	 * @return array
	 */
	public function fireEvents(array $context)
	{
		if (! isset($context['__env'])) {
			return $context;
		}

		$env      = $context['__env'];
		$viewName = $this->name ?: $this->getTemplateName();
		$view     = new View($env, $env->getEngineResolver()->resolve('twig'), $viewName, null, $context);
		
		$env->callCreator($view);
		$env->callComposer($view);

		return $view->getData();
	}

	/**
	 * Returns if events should be fired.
	 *
	 * @return bool
	 */
	public function shouldFireEvents()
	{
		return ! $this->firedEvents;
	}

	/**
	 * Set the firedEvents flag.
	 *
	 * @param  bool  $fired
	 * @return void
	 */
	public function setFiredEvents($fired = true)
	{
		$this->firedEvents = $fired;
	}

	/**
	 * Returns the attribute value for a given array/object.
	 *
	 * @param  mixed   $object             The object or array from where to get the item
	 * @param  mixed   $item               The item to get from the array or object
	 * @param  array   $arguments          An array of arguments to pass if the item is an object method
	 * @param  string  $type               The type of attribute (@see Twig_Template constants)
	 * @param  bool    $isDefinedTest      Whether this is only a defined check
	 * @param  bool    $ignoreStrictCheck  Whether to ignore the strict attribute check or not
	 * @return mixed                       The attribute value, or a Boolean when $isDefinedTest is true, or null when the attribute is not set and $ignoreStrictCheck is true
	 * @throws Twig_Error_Runtime          If the attribute does not exist and Twig is running in strict mode and $isDefinedTest is false
	 */
	protected function getAttribute($object, $item, array $arguments = array(), $type = 'Twig_Template::ANY_CALL', $isDefinedTest = false, $ignoreStrictCheck = false)
	{
		if (is_a($object, 'Illuminate\Database\Eloquent\Model')) {
			if (method_exists($object, $item)) {
				$return = call_user_func_array([$object, $item], $arguments);
			} else {
				$return = $object->getAttribute($item);

				if (is_null($return) and isset($object->item)) {
					$return = $object->$item;
				}
			}
		} else {
			$return = parent::getAttribute($object, $item, $arguments, $type, $isDefinedTest, $ignoreStrictCheck);
		}

		if (is_a($return, 'Illuminate\Database\Eloquent\Relations\Relation')) {
			$return = $object->getAttribute($item);
		}

		if ($return and $isDefinedTest) {
			return true;
		}

		return $return;
	}
}