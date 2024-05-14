module "ecs_app" {
  source = "./modules/ecs-service"

  depends_on = [
    module.ecs_cluster
  ]

  name         = local.namespace
  cluster_name = module.ecs_cluster.cluster_name
  min_capacity = 4
  max_capacity = 8

  image_repo = local.image_repo
  image_tag  = local.image_tag

  use_load_balancer       = var.use_load_balancer
  lb_dns_name             = aws_lb.main.dns_name
  lb_zone_id              = aws_lb.main.zone_id
  lb_vpc_id               = aws_vpc.main.id
  lb_listener_arn         = aws_lb_listener.http.arn
  lb_hosts                = ["www.${var.domain_name}"]
  lb_health_check_enabled = true
  lb_path                 = "/"

  container_memory_soft_limit = 768
  container_memory_hard_limit = 1024

  log_group_name                 = module.ecs_cluster.log_group_name
  service_discovery_namespace_id = module.ecs_cluster.service_discovery_namespace_id

  container_port          = 80
  network_mode            = "awsvpc"
  network_security_groups = [aws_security_group.ecs.id]
  network_subnets         = [aws_subnet.private.0.id]

  task_role_arn          = aws_iam_role.ecs_task_role.arn
  enable_execute_command = var.enable_execute_command

  predefined_metric_type = "ECSServiceAverageCPUUtilization"
  target_value           = 65

  ordered_placement_strategy = [
    {
      type  = "spread"
      field = "instanceId"
    },
    {
      type  = "binpack"
      field = "memory"
    }
  ]

  environment = [
    {
      name  = "APP_NAME"
      value = "Bursa Binelui"
    },
    {
      name  = "APP_ENV"
      value = var.env
    },
    {
      name  = "APP_DEBUG"
      value = tostring(false)
    },
    {
      name  = "APP_URL"
      value = "https://www.${var.domain_name}"
    },
    {
      name  = "EU_PLATESC_TEST_MODE"
      value = tostring(true)
    },
    {
      name  = "AWS_DEFAULT_REGION"
      value = var.region
    },
    {
      name  = "MAIL_MAILER"
      value = "ses"
    },
    {
      name  = "FILESYSTEM_DISK"
      value = "s3private"
    },
    {
      name  = "FILESYSTEM_DISK_PUBLIC"
      value = "s3public"
    },
    {
      name  = "AWS_BUCKET"
      value = module.s3_private.bucket
    },
    {
      name  = "AWS_PUBLIC_BUCKET"
      value = module.s3_public.bucket
    },
    {
      name  = "AWS_PUBLIC_URL"
      value = "https://www.${var.domain_name}"
    },
    {
      name  = "SENTRY_TRACES_SAMPLE_RATE"
      value = 0.3
    },
    {
      name  = "SENTRY_PROFILES_SAMPLE_RATE"
      value = 0.5
    },
    {
      name  = "GOOGLE_RECAPTCHA_THRESHOLD"
      value = 0.5
    },
    {
      name  = "GOOGLE_ANALYTICS_TRACKING_ID"
      value = var.google_analytics_tracking_id
    },
    {
      name  = "PRELAUNCH_SECRET"
      value = var.prelaunch_secret
    },
    {
      name  = "MAIL_FROM_ADDRESS"
      value = "no-reply@${var.domain_name}"
    },
    {
      name  = "AWS_PUBLIC_BUCKET_ROOT"
      value = "media"
    },
  ]

  secrets = [
    {
      name      = "APP_KEY"
      valueFrom = aws_secretsmanager_secret.app_key.arn
    },
    {
      name      = "DB_CONNECTION"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:engine::"
    },
    {
      name      = "DB_HOST"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:host::"
    },
    {
      name      = "DB_PORT"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:port::"
    },
    {
      name      = "DB_DATABASE"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:database::"
    },
    {
      name      = "DB_USERNAME"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:username::"
    },
    {
      name      = "DB_PASSWORD"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:password::"
    },
    {
      name      = "SENTRY_DSN"
      valueFrom = aws_secretsmanager_secret.sentry_dsn.arn
    },
    {
      name      = "GOOGLE_RECAPTCHA_SITE_KEY"
      valueFrom = "${aws_secretsmanager_secret.recaptcha.arn}:public_key::"
    },
    {
      name      = "GOOGLE_RECAPTCHA_SECRET_SITE_KEY"
      valueFrom = "${aws_secretsmanager_secret.recaptcha.arn}:private_key::"
    },
    {
      name      = "GOOGLE_MAPS_API_KEY"
      valueFrom = aws_secretsmanager_secret.google_maps.arn # TODO:
    },
  ]

  allowed_secrets = [
    aws_secretsmanager_secret.app_key.arn,
    aws_secretsmanager_secret.sentry_dsn.arn,
    aws_secretsmanager_secret.recaptcha.arn,
    aws_secretsmanager_secret.google_maps.arn,
    aws_secretsmanager_secret.rds.arn,
  ]
}

module "s3_public" {
  source = "./modules/s3"

  block_public_acls       = false
  block_public_policy     = false
  ignore_public_acls      = false
  restrict_public_buckets = false

  enable_versioning = var.env == "production"

  name   = "${local.namespace}-public"
  policy = data.aws_iam_policy_document.s3_cloudfront_public.json
}

resource "aws_s3_bucket_cors_configuration" "s3_public" {
  bucket = module.s3_public.bucket

  cors_rule {
    allowed_methods = ["GET"]
    allowed_origins = ["https://www.${var.domain_name}"]
    expose_headers  = ["ETag"]
    max_age_seconds = 86400
  }
}

module "s3_private" {
  source = "./modules/s3"

  enable_versioning = var.env == "production"

  name   = "${local.namespace}-private"
  policy = data.aws_iam_policy_document.s3_cloudfront_private.json
}

resource "aws_secretsmanager_secret" "app_key" {
  name = "${local.namespace}-secret_key-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "app_key" {
  secret_id     = aws_secretsmanager_secret.app_key.id
  secret_string = random_password.app_key.result
}

resource "aws_secretsmanager_secret" "sentry_dsn" {
  name = "${local.namespace}-sentry_dsn-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "sentry_dsn" {
  secret_id     = aws_secretsmanager_secret.sentry_dsn.id
  secret_string = var.sentry_dsn
}

resource "random_password" "app_key" {
  length  = 32
  special = true

  lifecycle {
    ignore_changes = [
      length,
      special
    ]
  }
}

resource "aws_secretsmanager_secret" "recaptcha" {
  name = "${local.namespace}-recaptcha-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "recaptcha" {
  secret_id = aws_secretsmanager_secret.recaptcha.id
  secret_string = jsonencode({
    public_key  = var.recaptcha_public_key
    private_key = var.recaptcha_private_key
  })
}

resource "aws_secretsmanager_secret" "google_maps" {
  name = "${local.namespace}-google_maps-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "google_maps" {
  secret_id     = aws_secretsmanager_secret.google_maps.id
  secret_string = var.google_maps_api_key
}
