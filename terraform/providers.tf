terraform {
  required_version = "~> 1.5"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.16"
    }
  }

  cloud {
    organization = "code4romania"

    workspaces {
      tags = [
        "bursa-binelui"
      ]
    }
  }
}

provider "aws" {
  region = var.region

  default_tags {
    tags = {
      app = "bursa-binelui"
      env = var.env
    }
  }
}

provider "aws" {
  alias  = "acm"
  region = "us-east-1"

  default_tags {
    tags = {
      app = "bursa-binelui"
      env = var.env
    }
  }
}
