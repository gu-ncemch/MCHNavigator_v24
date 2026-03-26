<?php 
$section = 'trainings';
$page = 'guided';
$page_title = "MCHfast: The Guided Search for the MCH Navigator";
include ('../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
  <?php include('../incl/leftnav.html'); ?>
  <div class="nine columns">
  <?php include('../incl/title.html'); ?> 

  <p>Use this guided search page to “choose and use” trainings based on your specific role and needs. Note, that choosing multiple options limits your search results.</p>

<style type="text/css">
  h3{display: inline-block;}
  .icon {
    position: relative;
    top: 8px;
    font-size: 2rem;
    width: 4rem;
    display: inline-block;
    text-align: center;
    color: #258dcd;
  }
  select {
    height:  35px;
  }
</style>
  <form action="/trainings/results.php" method="get">
   <link href="https://file.myfontastic.com/SnRrLrQPb9LwxBQsPhdgfb/icons.css" rel="stylesheet">                                
            <p><small>Note that many trainings are not mutually exclusive and thus are applicable to multiple audiences.</small></p>

            <div><i class="icon mch-user" aria-hidden="true"></i> I am 
            <div class="select">
            <span class="arr"></span>
              <select id="Primary_Audience" name="Primary_Audience">
                <option selected value="">browsing</option>
                <option value="Student">a student</option>
                <option value="Faculty">a faculty member in an academic setting</option>
                <option value="Professional">a professional in the field</option>
                <option value="Other">someone else (e.g., caregiver, family advocate)</option>
              </select>
            </div></div>

            <br>

            <div><i class="icon mch-book" aria-hidden="true"></i> I am looking for trainings on 
            <div class="select">
            <span class="arr"></span>
              <select id="Competencies_v4" name="Competencies_v4">
                <option selected value="">any topic</option>
                <optgroup label="MCH Leadership Competencies">
                  <option>MCH Knowledge Base/Context</option>
                  <option>Self-Reflection</option>
                  <option>Ethics</option>
                  <option>Critical Thinking</option>
                  <option>Communication</option>
                  <option>Negotiation and Conflict Resolution</option>
                  <option>Cultural Competency</option>
                  <option>Family-Professional Partnerships</option>
                  <option>Developing Others Through Teaching, Coaching, and Mentoring</option>
                  <option>Interdisciplinary/Interprofessional Team Building</option>
                  <option>Working with Communities and Systems</option>
                  <option>Policy</option>
                </optgroup>
                <optgroup label="Special Topics">
                  <option>CYSHCN</option>
                  <option>Data Usage (Note: there are many subtopics, but we just want to search “Data”)</option>
                  <option>Epidemiology (Note: there are many subtopics, but we just want to search “Epidemiology”)</option>
                  <option>Health Equity (Note: this is programmed as “Disparities” in database)</option>
                  <option>Lifecourse</option>
                  <option>Management (Note: there are many subtopics, but we just want to search “Management”)</option>
                  <option>Systems (Note: there are many subtopics, but we just want to search “Systems”)</option>
                  <option>Program Implementation</option>
                  <option>Quality Improvement</option>
                </optgroup>
              </select>
            </div> </div>

            <br>

            <div><i class="icon mch-star-half-o" aria-hidden="true"></i> That are <div class="select">
            <span class="arr"></span>
              <select id="Level" name="Level">
                <option selected value="">any</option>
                <option value="Introductory">introductory</option>
                <option value="Intermediate">intermediate</option>
                <option value="Advanced">advanced</option>
              </select>
            </div><!-- at this --> skill level.</div>
            

            <br>

            <div><i class="icon mch-clock" aria-hidden="true"></i> That are <!-- this amount of time: -->
            <div class="select">
            <span class="arr"></span>
              <select id="Length" name="Length">
                <option selected value="">any length of time</option>
                <option value="self-paced">self-paced</option>
                <option value="30">under 30 minutes</option>
                <option value="60">under 1 hour</option>
              </select>
            </div></div>
            <!-- new field that is either self-paced or int of value or blank -->

            <br>

            <div><i class="icon mch-calendar-1" aria-hidden="true"></i> That are from <!-- this time period: -->
            <div class="select">
            <span class="arr"></span>
              <select id="Year_Developed" name="Year_Developed">
                <option selected value="">all</option>
                <option value="3">the last three </option>
                <option value="5">the last five </option>
              </select>
            </div> years.</div>

            <br>

            <div><i class="icon mch-screen" aria-hidden="true"></i> Formatted as <!-- this training type: -->
            <div class="select">
            <span class="arr"></span>
              <select id="Type" name="Type">
                <option selected value="">Any Training Type</option>
                <option value="Interactive Learning Tool">Interactive Learning Tool</option>
                <option value="Narrated Slide Presentation">Narrated Slide Presentation</option>
                <option value="Online Course">Online Course</option>
                <option value="Podcast">Podcast</option>
                <option value="PowerPoint Presentation">PowerPoint Presentation</option>
                <option value="Video">Video</option>
                <option value="Webinar">Webinar</option>
              </select>
            </div></div>

            <br>

            <div><i class="icon mch-graduation-cap" aria-hidden="true"></i> That <div class="select">
            <span class="arr"></span>
              <select id="CE_Available" name="CE_Available">
                <option selected value="">do not need to</option>
                <option value="Yes">must</option>
              </select>
            </div> provide continuing education.</div>
           

            
            <p>
              <button type="submit">Search</button>
              <button type="reset" onClick="window.location.reload()" >Reset</button>
            </p>
          </form>

    
  </div>
</div>

<?php include('../incl/footer.html'); ?>
