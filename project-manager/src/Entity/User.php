<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[UniqueEntity('email')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private ?string $email;

    private ?string $plainPassword = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank()]
    private string $password = 'password';

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    
    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Assert\NotNull()]
    private \DateTimeImmutable $updatedAt;

    #[ORM\OneToMany(mappedBy: 'createdBy', targetEntity: Task::class, orphanRemoval: true)]
    private Collection $tasks;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Project::class, orphanRemoval: true)]
    private Collection $projects;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'members')]
    private Collection $projectAsMember;

    #[ORM\ManyToMany(targetEntity: Task::class, inversedBy: 'assignedTo')]
    private Collection $assignedTasks;

    public function __construct() {
         $this->createdAt = new \DateTimeImmutable();
         $this->updatedAt = new \DateTimeImmutable();
         $this->tasks = new ArrayCollection();
         $this->projects = new ArrayCollection();
         $this->projectAsMember = new ArrayCollection();
         $this->assignedTasks = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles = ['ROLE_USER'];

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    // pour effacer les données sensibles de l'utilisateur
    //  a la fin de l'utilisatezur, effacer les infos sensibles.
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setCreatedBy($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getCreatedBy() === $this) {
                $task->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setAuthor($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getAuthor() === $this) {
                $project->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjectAsMember(): Collection
    {
        return $this->projectAsMember;
    }

    public function addProjectAsMember(Project $projectAsMember): static
    {
        if (!$this->projectAsMember->contains($projectAsMember)) {
            $this->projectAsMember->add($projectAsMember);
        }

        return $this;
    }

    public function removeProjectAsMember(Project $projectAsMember): static
    {
        $this->projectAsMember->removeElement($projectAsMember);

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getAssignedTasks(): Collection
    {
        return $this->assignedTasks;
    }

    public function addAssignedTask(Task $assignedTask): static
    {
        if (!$this->assignedTasks->contains($assignedTask)) {
            $this->assignedTasks->add($assignedTask);
        }

        return $this;
    }

    public function removeAssignedTask(Task $assignedTask): static
    {
        $this->assignedTasks->removeElement($assignedTask);

        return $this;
    }
}
