module "ecs_app" {
  source = "./modules/ecs-service"

  depends_on = [
    module.ecs_cluster
  ]

  name         = local.namespace
  cluster_name = module.ecs_cluster.cluster_name
  min_capacity = 2
  max_capacity = 4

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

  container_memory_soft_limit = 512
  container_memory_hard_limit = 768

  log_group_name                 = module.ecs_cluster.log_group_name
  service_discovery_namespace_id = module.ecs_cluster.service_discovery_namespace_id

  container_port          = 80
  network_mode            = "awsvpc"
  network_security_groups = [aws_security_group.ecs.id]
  network_subnets         = [aws_subnet.private.0.id]

  task_role_arn          = aws_iam_role.ecs_task_role.arn
  enable_execute_command = var.enable_execute_command

  predefined_metric_type = "ECSServiceAverageCPUUtilization"
  target_value           = 70

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
      name  = "DEBUG"
      value = tostring(false)
    },
    {
      name  = "ENABLE_2FA"
      value = var.enable_2fa
    },
    {
      name  = "ENABLE_DJANGO_ADMIN"
      value = tostring(true)
    },
    {
      name  = "USE_S3"
      value = tostring(true)
    },
    {
      name  = "PROXY_SSL_HEADER"
      value = "HTTP_CLOUDFRONT_FORWARDED_PROTO"
    },
    {
      name  = "AWS_S3_CUSTOM_DOMAIN"
      value = "www.${var.domain_name}"
    },
    {
      name  = "AWS_STORAGE_DEFAULT_BUCKET_NAME"
      value = module.s3_public.bucket
    },
    {
      name  = "AWS_STORAGE_STATIC_BUCKET_NAME"
      value = module.s3_static.bucket
    },
    {
      name  = "AWS_STORAGE_PRIVATE_BUCKET_NAME"
      value = module.s3_private.bucket
    },
    {
      name  = "AWS_REGION_NAME"
      value = var.region
    },
    {
      name  = "EMAIL_BACKEND"
      value = "django_ses.SESBackend"
    },
    {
      name  = "DEFAULT_FROM_EMAIL"
      value = "no-reply@${var.domain_name}"
    },
    {
      name  = "DEFAULT_RECEIVE_EMAIL"
      value = var.receive_email
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
      name  = "GOOGLE_ANALYTICS_ID"
      value = var.google_analytics_id
    },
    {
      name  = "RECAPTCHA_REQUIRED_SCORE"
      value = var.recaptcha_required_score
    }
  ]

  secrets = [
    {
      name      = "SECRET_KEY"
      valueFrom = aws_secretsmanager_secret.app_secret_key.arn
    },
    {
      name      = "DATABASE_ENGINE"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:engine::"
    },
    {
      name      = "DATABASE_NAME"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:database::"
    },
    {
      name      = "DATABASE_USER"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:username::"
    },
    {
      name      = "DATABASE_PASSWORD"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:password::"
    },
    {
      name      = "DATABASE_HOST"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:host::"
    },
    {
      name      = "DATABASE_PORT"
      valueFrom = "${aws_secretsmanager_secret.rds.arn}:port::"
    },
    {
      name      = "SENTRY_DSN"
      valueFrom = aws_secretsmanager_secret.sentry_dsn.arn
    },
    {
      name      = "RECAPTCHA_PUBLIC_KEY"
      valueFrom = "${aws_secretsmanager_secret.recaptcha.arn}:public_key::"
    },
    {
      name      = "RECAPTCHA_PRIVATE_KEY"
      valueFrom = "${aws_secretsmanager_secret.recaptcha.arn}:private_key::"
    },
  ]

  allowed_secrets = [
    aws_secretsmanager_secret.app_secret_key.arn,
    aws_secretsmanager_secret.sentry_dsn.arn,
    aws_secretsmanager_secret.recaptcha.arn,
    aws_secretsmanager_secret.rds.arn,
  ]
}

module "s3_static" {
  source = "./modules/s3"

  block_public_acls       = false
  block_public_policy     = false
  ignore_public_acls      = false
  restrict_public_buckets = false

  name   = "${local.namespace}-static"
  policy = data.aws_iam_policy_document.s3_cloudfront_static.json
}

module "s3_public" {
  source = "./modules/s3"

  block_public_acls       = false
  block_public_policy     = false
  ignore_public_acls      = false
  restrict_public_buckets = false

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

  name   = "${local.namespace}-private"
  policy = data.aws_iam_policy_document.s3_cloudfront_private.json
}

resource "aws_secretsmanager_secret" "app_secret_key" {
  name = "${local.namespace}-secret_key-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "app_secret_key" {
  secret_id     = aws_secretsmanager_secret.app_secret_key.id
  secret_string = random_password.app_secret_key.result
}

resource "aws_secretsmanager_secret" "sentry_dsn" {
  name = "${local.namespace}-sentry_dns-${random_string.secrets_suffix.result}"
}

resource "aws_secretsmanager_secret_version" "sentry_dsn" {
  secret_id     = aws_secretsmanager_secret.sentry_dsn.id
  secret_string = var.sentry_dsn
}

resource "random_password" "app_secret_key" {
  length  = 50
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
