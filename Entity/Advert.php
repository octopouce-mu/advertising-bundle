<?php

namespace Octopouce\AdvertisingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Ad
 *
 * @ORM\Table(name="adv_advert")
 * @ORM\Entity()
 */
class Advert
{
    use ORMBehaviors\Timestampable\Timestampable;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="image_path", type="string", length=255)
     */
    private $imagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="ad_link", type="string", length=255)
     */
    private $advertLink;

    /**
     * @var string
     *
     * @ORM\Column(name="image_tablet_path", type="string", length=255)
     */
    private $imageTabletPath;

    /**
     * @var string
     *
     * @ORM\Column(name="image_mobile_path", type="string", length=255)
     */
    private $imageMobilePath;

    /**
     * @var bool
     *
     * @ORM\Column(name="interactive", type="boolean")
     */
    private $interactive;

    /**
     * @var string
     *
     * @ORM\Column(name="interactive_title", type="string", nullable=true)
     */
    private $interactiveTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="interactive_accroche_1", type="string", nullable=true)
     */
    private $interactiveAccroche1;

    /**
     * @var string
     *
     * @ORM\Column(name="interactive_accroche_2", type="string", nullable=true)
     */
    private $interactiveAccroche2;

    /**
     * @var string
     *
     * @ORM\Column(name="interactive_description", type="text", nullable=true)
     */
    private $interactiveDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="interactive_telephone", type="string", nullable=true)
     */
    private $interactiveTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="interactive_email", type="string", nullable=true)
     */
    private $interactiveEmail;

    /**
     * Many Adverts have Many Adzones.
     *
     * @ORM\ManyToMany(targetEntity="Adzone", mappedBy="adverts")
     */
    private $adzones;

    /**
     * @var Campaign
     *
     * @ORM\ManyToOne(targetEntity="Campaign", inversedBy="adverts")
     * @ORM\JoinColumn(name="campaign_id", referencedColumnName="id")
     */
    private $campaign;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Octopouce\AdvertisingBundle\Entity\Statistic\View", mappedBy="advert", cascade={"persist", "remove"})
     */
    private $statsView;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Octopouce\AdvertisingBundle\Entity\Statistic\Click", mappedBy="advert", cascade={"persist", "remove"})
     */
    private $statsClick;


    function __construct()
    {
        $this->adzones = new ArrayCollection();
        $this->interactive = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Advert
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set imagePath
     *
     * @param string $imagePath
     *
     * @return Advert
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * Get imagePath
     *
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set advertLink
     *
     * @param string $advertLink
     *
     * @return Advert
     */
    public function setAdvertLink($advertLink)
    {
        $this->advertLink = $advertLink;

        return $this;
    }

    /**
     * Get adLink
     *
     * @return string
     */
    public function getAdvertLink()
    {
        return $this->advertLink;
    }

    /**
     * Set imageTabletPath
     *
     * @param string $imageTabletPath
     *
     * @return Advert
     */
    public function setImageTabletPath($imageTabletPath)
    {
        $this->imageTabletPath = $imageTabletPath;

        return $this;
    }

    /**
     * Get imageTabletPath
     *
     * @return string
     */
    public function getImageTabletPath()
    {
        return $this->imageTabletPath;
    }

    /**
     * Set imageMobilePath
     *
     * @param string $imageMobilePath
     *
     * @return Advert
     */
    public function setImageMobilePath($imageMobilePath)
    {
        $this->imageMobilePath = $imageMobilePath;

        return $this;
    }

    /**
     * Get imageMobilePath
     *
     * @return string
     */
    public function getImageMobilePath()
    {
        return $this->imageMobilePath;
    }

    /**
     * Set interactive
     *
     * @param boolean $interactive
     *
     * @return Advert
     */
    public function setInteractive($interactive)
    {
        $this->interactive = $interactive;

        return $this;
    }

    /**
     * Get interactive
     *
     * @return bool
     */
    public function getInteractive()
    {
        return $this->interactive;
    }

    /**
     * Set interactiveTitle
     *
     * @param string $interactiveTitle
     *
     * @return Advert
     */
    public function setInteractive_title($interactiveTitle)
    {
        $this->interactiveTitle = $interactiveTitle;

        return $this;
    }

    /**
     * Get interactiveTitle
     *
     * @return string
     */
    public function getInteractiveTitle()
    {
        return $this->interactiveTitle;
    }

    /**
     * Set interactiveAccroche1
     *
     * @param string $interactiveAccroche1
     *
     * @return Advert
     */
    public function setInteractive_accroche1($interactiveAccroche1)
    {
        $this->interactiveAccroche1 = $interactiveAccroche1;

        return $this;
    }

    /**
     * Get interactiveAccroche1
     *
     * @return string
     */
    public function getInteractiveAccroche1()
    {
        return $this->interactiveAccroche1;
    }

    /**
     * Set interactiveAccroche2
     *
     * @param string $interactiveAccroche2
     *
     * @return Advert
     */
    public function setInteractive_accroche2($interactiveAccroche2)
    {
        $this->interactiveAccroche2 = $interactiveAccroche2;

        return $this;
    }

    /**
     * Get interactiveAccroche2
     *
     * @return string
     */
    public function getInteractiveAccroche2()
    {
        return $this->interactiveAccroche2;
    }

    /**
     * Set interactiveDescription
     *
     * @param string $interactiveDescription
     *
     * @return Advert
     */
    public function setInteractive_description($interactiveDescription)
    {
        $this->interactiveDescription = $interactiveDescription;

        return $this;
    }

    /**
     * Get interactiveDescription
     *
     * @return string
     */
    public function getInteractiveDescription()
    {
        return $this->interactiveDescription;
    }

    /**
     * Set interactiveTelephone
     *
     * @param string $interactiveTelephone
     *
     * @return Advert
     */
    public function setInteractive_telephone($interactiveTelephone)
    {
        $this->interactiveTelephone = $interactiveTelephone;

        return $this;
    }

    /**
     * Get interactiveTelephone
     *
     * @return string
     */
    public function getInteractiveTelephone()
    {
        return $this->interactiveTelephone;
    }

    /**
     * Set interactiveEmail
     *
     * @param string $interactiveEmail
     *
     * @return Advert
     */
    public function setInteractive_email($interactiveEmail)
    {
        $this->interactiveEmail = $interactiveEmail;

        return $this;
    }

    /**
     * Get interactiveEmail
     *
     * @return string
     */
    public function getInteractiveEmail()
    {
        return $this->interactiveEmail;
    }

    /**
     * Add adzone
     *
     * @param Adzone $adzone
     *
     * @return Advert
     */
    public function addAdzone(Adzone $adzone)
    {
        $this->adzones[] = $adzone;

        return $this;
    }

    /**
     * Remove adzone
     *
     * @param Adzone $adzone
     */
    public function removeAdzone(Adzone $adzone)
    {
        $this->adzones->removeElement($adzone);
    }

    /**
     * Get adzones
     *
     * @return ArrayCollection
     */
    public function getAdzones()
    {
        return $this->adzones;
    }

    /**
     * Set campaign
     *
     * @param Campaign $campaign
     *
     * @return Advert
     */
    public function setCampaign(Campaign $campaign = null)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return Campaign
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * Set interactiveTitle.
     *
     * @param string|null $interactiveTitle
     *
     * @return Advert
     */
    public function setInteractiveTitle($interactiveTitle = null)
    {
        $this->interactiveTitle = $interactiveTitle;

        return $this;
    }

    /**
     * Set interactiveAccroche1.
     *
     * @param string|null $interactiveAccroche1
     *
     * @return Advert
     */
    public function setInteractiveAccroche1($interactiveAccroche1 = null)
    {
        $this->interactiveAccroche1 = $interactiveAccroche1;

        return $this;
    }

    /**
     * Set interactiveAccroche2.
     *
     * @param string|null $interactiveAccroche2
     *
     * @return Advert
     */
    public function setInteractiveAccroche2($interactiveAccroche2 = null)
    {
        $this->interactiveAccroche2 = $interactiveAccroche2;

        return $this;
    }

    /**
     * Set interactiveDescription.
     *
     * @param string|null $interactiveDescription
     *
     * @return Advert
     */
    public function setInteractiveDescription($interactiveDescription = null)
    {
        $this->interactiveDescription = $interactiveDescription;

        return $this;
    }

    /**
     * Set interactiveTelephone.
     *
     * @param string|null $interactiveTelephone
     *
     * @return Advert
     */
    public function setInteractiveTelephone($interactiveTelephone = null)
    {
        $this->interactiveTelephone = $interactiveTelephone;

        return $this;
    }

    /**
     * Set interactiveEmail.
     *
     * @param string|null $interactiveEmail
     *
     * @return Advert
     */
    public function setInteractiveEmail($interactiveEmail = null)
    {
        $this->interactiveEmail = $interactiveEmail;

        return $this;
    }

    /**
     * Add statsView.
     *
     * @param \Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView
     *
     * @return Advert
     */
    public function addStatsView(\Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView)
    {
        $this->statsView[] = $statsView;

        return $this;
    }

    /**
     * Remove statsView.
     *
     * @param \Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeStatsView(\Octopouce\AdvertisingBundle\Entity\Statistic\View $statsView)
    {
        return $this->statsView->removeElement($statsView);
    }

    /**
     * Get statsView.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getStatsView()
    {
        return $this->statsView;
    }

    /**
     * Add statsClick.
     *
     * @param \Octopouce\AdvertisingBundle\Entity\Statistic\Click $statsClick
     *
     * @return Advert
     */
    public function addStatsClick(\Octopouce\AdvertisingBundle\Entity\Statistic\Click $statsClick)
    {
        $this->statsClick[] = $statsClick;

        return $this;
    }

    /**
     * Remove statsClick.
     *
     * @param \Octopouce\AdvertisingBundle\Entity\Statistic\Click $statsClick
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeStatsClick(\Octopouce\AdvertisingBundle\Entity\Statistic\Click $statsClick)
    {
        return $this->statsClick->removeElement($statsClick);
    }

    /**
     * Get statsClick.
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getStatsClick()
    {
        return $this->statsClick;
    }
}
