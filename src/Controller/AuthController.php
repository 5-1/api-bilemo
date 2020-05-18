<?php

namespace App\Controller;

use App\Exception\ResourceValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class AuthController extends AbstractController
{
    /**
     * @Rest\Post(
     *     path="/api/register",
     *     name="app_register")
     * @Rest\View(statusCode=201)
     * @ParamConverter(
     *     "user",
     *      converter="fos_rest.request_body",
     *      options={
     *         "validator"={"groups"="create"}
     *     }
     * )
     * @param User $user
     * @param ConstraintViolationListInterface $violations
     * @param UserPasswordEncoderInterface $encoder
     * @return User
     * @throws ResourceValidationException
     *
     * @SWG\Response(
     *     response=201,
     *     description="add user",
     *     @SWG\Schema(
     *     type="array",
     *     @SWG\Items(ref=@Model(type=user::class))
     * )
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Return when a violation is raised by validation"
     * )
     *
     *
     * @SWG\Parameter(
     *          name="Body",
     *          required=true,
     *          in="body",
     *          type="string",
     *          @SWG\Schema(
     *             required={"username", "plainPassword", "email"},
     *             @SWG\Property(property="username", type="string"),
     *             @SWG\Property(property="plainPassword", type="string"),
     *             @SWG\Property(property="email", type="string"),
     *             @SWG\Property(property="first_name", type="string"),
     *             @SWG\Property(property="second_name", type="string"),
     *     ))
     *
     * @SWG\Tag(name="User")
     */
    public function register(User $user, ConstraintViolationListInterface $violations, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        if (count($violations) > 0) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf('Field %s: %s ', $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
        $user->setRoles(['ROLE_USER']);

        $em->persist($user);
        $em->flush();


        return $user;
    }


    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }
}