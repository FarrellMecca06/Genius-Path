<?php include  __DIR__ . '/header.php'; ?>
<main class="page">
<section class="hero">
    <div class="hero-text">
        <h1>Find Your Path. Build Your Future.</h1>
        <p>
            </p>
        <div class="hero-actions">
           <a href="<?php echo home_url('/self_discovery.php'); ?>" class="btn-primary">Start Self Discovery</a>
        </div>
        <div class="hero-tags">
            <span>Career Roadmaps</span>
            <span>Study Analytics</span>
            <span>Motivation Boost</span>
        </div>
    </div> <div class="hero-image">
        <img src="<?php echo get_template_directory_uri(); ?>/../image/utama.png" alt="Illustration of students exploring career paths">
    </div>

</section>

    <section class="cards-section">

        <div class="cards-grid">
            <article class="card card-tech">
                <div class="card-badge">Self Discovery</div>
                <h3>Strength & Interest Mapping</h3>
                <p>Short quizzes that reveal your strongest subjects, skills, and work style.</p>
                <ul>
                    <li>Academic & interest questionnaire</li>
                    <li>Personality & values insights</li>
                    <li>Instant summary of your profile</li>
                </ul>
                <a href="<?php echo home_url('/self_discovery.php'); ?>" class="btn-card">
                    Start assessment
                </a>
            </article>

            <article class="card card-business">
                <div class="card-badge">Career Paths</div>
                <h3>Smart Career Suggestions</h3>
                <p>See which careers fit your profile and compare them side‑by‑side.</p>
                <ul>
                    <li>Recommended careers list</li>
                    <li>Roadmaps & required skills</li>
                    <li>Salary & job outlook overview</li>
                </ul>
                <a href="<?php echo home_url('/careers.php'); ?>" class="btn-card">
                    View recommendations
                </a>
            </article>

            <article class="card card-progress">
                <div class="card-badge">Progress</div>
                <h3>Career Readiness Dashboard</h3>
                <p>Track your academic, skills, and consistency scores in one place.</p>
                <ul>
                    <li>Academic & skill scores</li>
                    <li>Weekly & monthly insights</li>
                    <li>Career readiness score</li>
                </ul>
                <a href="<?php echo home_url('/dashboard.php'); ?>" class="btn-card">
                    Open dashboard
                </a>
            </article>
        </div>
    </section>
</main>
<?php 
include __DIR__ . '/footer.php'; 
?>