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
     * 验证场景
     *
     * @var string
     */
    public $scene = [];

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
     * Create the default validator instance.
     *
     * @param ValidationFactory $factory
     *
     * @return Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        return $factory->make(
            $this->validationData(), $this->getSceneRules(),
            $this->messages(), $this->attributes()
        );
    }

    /**
     * 获取场景验证规则
     *
     * @return array
     */
    protected function getSceneRules()
    {
        return $this->handleScene($this->container->call([$this, 'rules']));
    }

    /***
     * 基于路由名称的场景验证
     *
     * @param array $rule
     * @return array
     */
    public function handleScene(array $rule)
    {
        $arr = [];

        foreach (($scene = $this->scene[$this->getSceneName()] ?? []) as $item){
            if( isset($rule[$item])){
                $arr[$item] = $rule[$item];
            }
        }

        return  $arr ?: $rule;
    }

    /**
     * 获取场景名称
     *
     * @return mixed
     */
    public function getSceneName()
    {
        return $this->input('_scene', $this->route()->getName());
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        return $this->all();
    }

    /**
     * 通过重写 failedValidation，方便Request 类抛出异常
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->failed($validator->errors()->first())
        );
    }
}