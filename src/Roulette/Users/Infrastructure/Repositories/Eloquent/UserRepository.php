<?php

namespace Src\Roulette\Users\Infrastructure\Repositories\Eloquent;

use App\Models\Transaction;
use App\Models\User as UserModel;
use Closure;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Src\Management\Login\Domain\Contracts\LoginRepositoryContract;
use Src\Roulette\Users\Domain\Contracts\UserRepositoryContract;
use Src\Roulette\Users\Domain\User;

final class UserRepository implements LoginRepositoryContract, UserRepositoryContract
{
  public function checkUserPassword(string $email, string $password): bool
  {
    $user = UserModel::where('email', $email)->first();
    return ($user && Hash::check($password, $user->password));
  }

  public function createUserToken(string $email): string
  {
    $user = UserModel::where('email', $email)->first();
    // Invalida todos los tokens anteriores del usuario, se comenta por el modo estricto en desarrollo
    // $user->tokens()->delete();
    $isAdmin = $this->isAdmin($email);
    // Crea token con scope adicional si el usuario es administrador
    $token = $user->createToken('authToken', $isAdmin ? ['admin'] : [])->plainTextToken;

    return $token;
  }

  public function isAdmin(string $email): bool
  {
    //se deja en esta parte que se pueda cambiar a un sistema mas escalable y robusto
    return $email == env('ADMIN_EMAIL');
  }


  public function userName(string $email)
  {
    $user = UserModel::where('email', $email)->first();
    return $user->name;
  }

  public function createUser(User $user): int
  {
    $userModel = new UserModel();
    $userModel->name = $user->name();
    $userModel->email = $user->email();
    $userModel->password = Hash::make($user->password());
    $userModel->save();
    return $userModel->id;
  }

  public function checkUserTokenReturnEmail(string $token): ?string
  {
    $tokenModel = PersonalAccessToken::findToken($token);
    if ($tokenModel && $tokenModel->tokenable) {
      return $tokenModel->tokenable->email;
    }
    return null;
  }

  public function updateBalance($userId, $balance): bool
  {
    $user = UserModel::find($userId);
    $user->balance = $balance;
    return $user->save();
  }

  public function findAll(): array
  {
    return UserModel::all()
      ->map(function ($user) {
        $balance = $this->getBalance($user->id);
        return ($this->eloquentModel())($user, $balance);
      })
      ->toArray();
  }

  public function getBalance(int $userId): int
  {
    $balance = Transaction::where('user_id', $userId)->orderBy('id', 'desc')->first();
    return $balance ? $balance->balance_after : 0;
  }

  public function eloquentModel(): Closure
  {
    return fn($user, $balance) => new User(
      name: $user->name,
      email: $user->email,
      balance: $balance,
      id: $user->id,
    );
  }


}
