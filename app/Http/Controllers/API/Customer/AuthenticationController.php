<?php

namespace Drinking\Http\Controllers\API\Customer;

use Drinking\Http\Controllers\Controller;
use Drinking\Models\OAuthClient;
use Drinking\Models\User;
use Drinking\Repositories\OAuthClientRepository;
use Drinking\Repositories\UserRepository;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AuthenticationController extends Controller
{
    protected $table = 'oauth_clients';
    /**
     * @var OAuthClientRepository
     */
    private $oAuthClientRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(OAuthClientRepository $oAuthClientRepository, UserRepository $userRepository)
    {

        $this->oAuthClientRepository = $oAuthClientRepository;
        $this->userRepository = $userRepository;
    }



    //TODO: Make transaction into database
    //TODO: Modificar a rota /register-user para cliar novo client inclusive, não somente user
    //TODO: Configurar para verificar se o cliente já existe, se já existir não precisa fazer muita coisa que tá a
    //TODO: usar repositories para fazer modificações
    //TODO: descobrir qual a merda de problema na tabela do banco de dados que não deixa nem editar os campos
    //TODO: fazer o código inteiro deste método testar se o usuário entrou a senha correta, caso já exista cadastro
    public function registerUser(Request $request){

        $email = \Illuminate\Support\Facades\Input::get('email');
        $password = \Illuminate\Support\Facades\Input::get('password');

        if(!$this->userRepository->getByEmail($email)) {
            $user = new User(array(
                'name' => \Illuminate\Support\Facades\Input::get('name'),
                'email' => \Illuminate\Support\Facades\Input::get('email'),
                'password' => bcrypt(\Illuminate\Support\Facades\Input::get('password')),
            ));
            $user->save();

            $oauth_client = new OAuthClient();
            $oauth_client->user_id = $user->id;
            $oauth_client->email = $email;
            $oauth_client->name = $user->name;
            $oauth_client->secret = base64_encode(hash_hmac('sha256', $password, 'secret', true));

            $oauth_client->password_client = 1;
            $oauth_client->personal_access_client = 0;
            $oauth_client->redirect = '';
            $oauth_client->revoked = 0;
            $oauth_client->save();
        }
        else{
            $user = $this->userRepository->getByEmail($email);

            if(!$this->oAuthClientRepository->getByEmail($email)){
                $oauth_client = new OAuthClient();
                $oauth_client->user_id = $user->id;
                $oauth_client->email = $email;
                $oauth_client->name = $user->name;
                $oauth_client->secret = base64_encode(hash_hmac('sha256', $password, 'secret', true));

                $oauth_client->password_client = 1;
                $oauth_client->personal_access_client = 0;
                $oauth_client->redirect = '';
                $oauth_client->revoked = 0;
                $oauth_client->save();
            }
        }

//    return [
//        'message' => 'user successfully created.'
//    ];

        $acessToken = $user->createToken('Acess Token')->accessToken;

        return $acessToken;
    }
}
