<?php include 'header.php'; ?>
<main class="page">
<section class="hero">
    <div class="hero-text">
        <h1>Find Your Path. Build Your Future.</h1>
        <p>
            </p>
        <div class="hero-actions">
            <button class="btn-primary" onclick="window.location='self_discovery.php'">Start Self Discovery</button>
        </div>
        <div class="hero-tags">
            <span>Career Roadmaps</span>
            <span>Study Analytics</span>
            <span>Motivation Boost</span>
        </div>
    </div> <div class="hero-image">
        <img src="../image/utama.png" alt="Illustration of students exploring career paths">
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
                <button class="btn-card" onclick="window.location='self_discovery.php'">
                    Start assessment
                </button>
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
                <button class="btn-card" onclick="window.location='careers.php'">
                    View recommendations
                </button>
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
                <button class="btn-card" onclick="window.location='dashboard.php'">
                    Open dashboard
                </button>
            </article>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>