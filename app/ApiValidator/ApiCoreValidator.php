<?php


namespace App\ApiValidator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

abstract class ApiCoreValidator
{
  protected $req;
  /*
     * Запускает валидацю
     * Если не проходит валидацию
     * возращает массив с ошибками
     * @return true | errors
     * */
  public function init(Request $request)
  {
    $this->req = $request->input();

    $validator = Validator::make(
      $this->req,
      $this->rules(),
      $this->messages(),
      $this->attributes()
    );

    if ($validator->fails()) {
      return [
        'errors' => $validator->errors()
      ];
    }

    return false;
  }

  /*
     * Правила валидации
     * @return Array
     * */
  abstract function rules();

  /*
      * Сообщения при ошибке
      * @return Array
      * */
  function messages()
  {
    return [
      'unique' => ":attribute уже существует в базе данных",
      'required' => ":attribute не может быть пустым",
      'integer' => ':attribute должно быть числом',
      'integer' => ':attribute должно быть числом',
      'regex' => ':attribute имеет не верный формат',
      'exists' => ':attribute отсутствует в базе данных',
      'phone.regex' => 'Неверный формат номера телефона, пожалуйста, попробуйте снова начиная с +7',
    ];
  }

  /*
      * Название атрибутов
      * Подставляет значения вместо полей в БД
      * @return Array
      * */
  abstract function attributes();
}
