<?php
namespace Caffeinated\Sapling\Twig;

use Illuminate\View\View;
use Twig_Template;

abstract class Template extends Twig_Template
{
	protected $firedEvents = false;

	public function display(array $context, array $blocks = [])
	{
		if ($this->shouldFireEvents()) {
			$context = $this->fireEvents($context);
		}

		parent::display($context, $blocks);
	}

	public function fireEvents($context)
	{
		if (! isset($context['__env'])) {
			return $context;
		}

		$env  = $context['__env'];
		$view = new View($env, $env->getEngineResolver()->resolve('twig')), $this->getTemplateName(), null, $context);
		
		$env->callCreate($view);
		$env->callComposer($view);

		return $view->getData();
	}

	public function shouldFireEvents()
	{
		return ! $this->firedEvents;
	}

	protected function getAttribute(
		$object,
		$item,
		array $arguments = [],
		$type = 'Twig_Template::ANY_CALL',
		$isDefinedTest = false,
		$ignoreStrictCheck = false)
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