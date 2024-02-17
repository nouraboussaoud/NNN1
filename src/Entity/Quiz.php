<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $quizName = null;

    #[ORM\Column(length: 255)]
    private ?string $descQuiz = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(mappedBy: 'quiz', targetEntity: Question::class)]
    private Collection $Questions;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'quizzes')]
    private Collection $UserQuiz;

    #[ORM\Column]
    private ?int $Points = null;

    public function __construct()
    {
        $this->Questions = new ArrayCollection();
        $this->UserQuiz = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuizName(): ?string
    {
        return $this->quizName;
    }

    public function setQuizName(string $quizName): static
    {
        $this->quizName = $quizName;

        return $this;
    }

    public function getDescQuiz(): ?string
    {
        return $this->descQuiz;
    }

    public function setDescQuiz(string $descQuiz): static
    {
        $this->descQuiz = $descQuiz;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->Questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->Questions->contains($question)) {
            $this->Questions->add($question);
            $question->setQuiz($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->Questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getQuiz() === $this) {
                $question->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserQuiz(): Collection
    {
        return $this->UserQuiz;
    }

    public function addUserQuiz(User $userQuiz): static
    {
        if (!$this->UserQuiz->contains($userQuiz)) {
            $this->UserQuiz->add($userQuiz);
        }

        return $this;
    }

    public function removeUserQuiz(User $userQuiz): static
    {
        $this->UserQuiz->removeElement($userQuiz);

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->Points;
    }

    public function setPoints(int $Points): static
    {
        $this->Points = $Points;

        return $this;
    }
}
