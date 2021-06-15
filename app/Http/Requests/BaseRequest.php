<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class BaseRequest
 *
 * @package App\Http\Requests
 */
class BaseRequest extends FormRequest
{
    use ApiResponse;

    /**
     * @var null
     */
    protected $scene = null;

    /**
     * 是否自动验证
     *
     * @var bool
     */
    protected $autoValidate = true;

    /**
     * @var array
     */
    protected $onlyRule=[];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateResolved()
    {
        if (method_exists($this, 'autoValidate')) {
            $this->autoValidate = $this->container->call([$this, 'autoValidate']);
        }

        if ($this->autoValidate) {
            $this->handleValidate();
        }
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function handleValidate()
    {
        $this->prepareForValidation();

        if (! $this->passesAuthorization()) {
            $this->failedAuthorization();
        }

        $instance = $this->getValidatorInstance();

        if ($instance->fails()) {
            $this->failedValidation($instance);
        }
    }

    /**
     * 定义 getValidatorInstance 下 validator 验证器
     *
     * @param $factory
     * @return mixed
     */
    public function validator($factory)
    {
        return $factory->make($this->validationData(), $this->getRules(), $this->messages(), $this->attributes());
    }

    /**
     * 验证方法（关闭自动验证时控制器调用）
     *
     * @param string $scene  场景名称 或 验证规则
     */
    public function validate($scene = '')
    {
        if (!$this->autoValidate) {
            if (is_array($scene)) {
                $this->onlyRule = $scene;
            } else {
                $this->scene = $scene;
            }

            $this->handleValidate();
        }
    }

    /**
     * 获取 rules
     *
     * @return array
     */
    protected function getRules()
    {
        return $this->handleScene($this->container->call([$this, 'rules']));
    }

    /**
     * 场景验证
     *
     * @param array $rule
     * @return array
     */
    protected function handleScene(array $rule)
    {
        if ($this->onlyRule) {
            return $this->handleRule($this->onlyRule, $rule);
        }

        $sceneName = $this->getSceneName();
        if ($sceneName && method_exists($this, 'scene')) {
            $scene = $this->container->call([$this, 'scene']);
            if (array_key_exists($sceneName, $scene)) {
                return $this->handleRule($scene[$sceneName], $rule);
            }
        }
        return  $rule;
    }

    /**
     * 处理Rule
     *
     * @param array $sceneRule
     * @param array $rule
     *
     * @return array
     */
    private function handleRule(array $sceneRule, array $rule)
    {
        $rules = [];
        foreach ($sceneRule as $key => $value) {
            if (is_numeric($key) && array_key_exists($value, $rule)) {
                $rules[$value] = $rule[$value];
            } else {
                $rules[$key] = $value;
            }
        }
        return $rules;
    }

    /**
     * 获取场景名称
     *
     * @return string
     */
    protected function getSceneName()
    {
        return is_null($this->scene) ? $this->route()->getAction('_scene') : $this->scene;
    }

    /**
     * 通过重写 failedValidation，方便Request 类抛出异常
     *
     * @param Validator $validator
     * @throws
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->failed($validator->errors()->first())
        );
    }
}
