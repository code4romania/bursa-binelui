locals {
  namespace  = "bursa-binelui-${var.env}"
  image_repo = "code4romania/bursa-binelui"
  image_tag  = var.docker_tag

  availability_zone = data.aws_availability_zones.current.names[0]

  domains = [
    var.domain_name,
    "www.${var.domain_name}",
  ]

  ecs = {
    instance_types = {
      "t3a.medium" = ""
    }
  }

  db = {
    name           = "bursa-binelui"
    instance_class = var.env == "production" ? "db.t4g.micro" : "db.t4g.small"
  }

  networking = {
    cidr_block = "10.0.0.0/16"

    public_subnets = [
      "10.0.1.0/24",
      "10.0.2.0/24",
      "10.0.3.0/24"
    ]

    private_subnets = [
      "10.0.4.0/24",
      "10.0.5.0/24",
      "10.0.6.0/24"
    ]
  }
}
