<?php
namespace modelSpace;

class Record implements \JsonSerializable {
    /** @var string */
    private $title;
    /** @var string */
    private $company;
    /** @var string */
    private $address;

    public function setTitle(string $title) {
        $this->title = $title;
    }
    public function getTitle() { return $this->title; }

    public function setCompany(string $company) {
        $this->company = $company;
    }

    public function getCompany() { return $this->company; }

    public function setAddress(string $address) {
        $this->address = $address;
    }

    public function getAddress() { return $this->address; }

    public function jsonSerialize() {
        return ['title' => $this->title, 'company' => $this->company, 'address' => $this->address];
    }
}
