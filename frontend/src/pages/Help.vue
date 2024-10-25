<template>
  <PageHeader> Help </PageHeader>
  <header>
    <h2 class="uppercase text-2xl font-semibold">Browse these topics</h2>
  </header>

  <section class="border-black border-2 rounded-xl text-xl p-4">
    <q-list bordered class="rounded-borders">
      <q-expansion-item
        v-for="topic in topics"
        :key="topic.label"
        :label="topic.label"
        :icon="topic.icon"
        expand-separator
      >
        <q-card>
          <q-card-section>
            {{ topic.description }}
          </q-card-section>
        </q-card>

        <q-expansion-item
          v-for="subtopic in topic.subtopics"
          :key="subtopic.label"
          :label="subtopic.label"
          switch-toggle-side
          dense-toggle
          :header-inset-level="0.5"
          :content-inset-level="1"
        >
          <q-card>
            <q-card-section>
              {{ subtopic.description }}
            </q-card-section>
          </q-card>
        </q-expansion-item>
      </q-expansion-item>
    </q-list>
  </section>
</template>

<script setup>
const topics = [
  {
    label: "Overview of the Reporting System",
    icon: "mail",
    description:
      "The CSDL Report and Support System is designed to make student support easy and accessible. Here are its main features:",
    subtopics: [
      {
        label: "User-Friendly Reporting",
        description:
          "An intuitive interface lets users customize their reports, making it simple for everyone to use.",
      },
      {
        label: "Automated Notifications",
        description:
          "Stay informed with automatic updates on the status of your requests, ensuring clear communication.",
      },
      {
        label: "Easy Reporting Forms",
        description:
          "Our built-in forms allow quick reporting and information collection, eliminating the need for third-party apps.",
      },
      {
        label: "Appointment Scheduling",
        description:
          "Automatically schedule meetings between students and staff based on availability, reducing delays.",
      },
      {
        label: "Privacy and Confidentiality",
        description:
          "Students can report sensitive issues securely, with their identities protected.",
      },
      {
        label: "Efficient Data Management",
        description:
          "Organized storage makes it easy to retrieve past records, helping staff track and analyze student concerns.",
      },
      {
        label: "Mobile Accessibility",
        description:
          "Report issues and receive notifications anytime, anywhere, thanks to our mobile-friendly design.",
      },
      {
        label: "Finish",
        description: "This system aims to enhance communication and support, improving the overall student experience.",
      }
    ],
  },
  {
    label: "Getting Started with the Reporting System",
    icon: "start",
    description:
      "Ready to learn about the app? Follow these simple steps to get started:",
    subtopics: [
      {
        label: "Access the System",
        description:
          "Visit the CSDL Report and Support System through the website or download the mobile app.",
      },
      {
        label: "Log In",
        description:
          "Use your credentials with Phinma mail and provided password to log in. Make sure to change the password after first use.",
      },
      {
        label: "Start a Report",
        description: "Click the plus button to create a new report.",
      },
      {
        label: "Choose Your Issue",
        description:
          "Select the category that best fits your concern (e.g., financial assistance, complaints, behavioral issues).",
      },
      {
        label: "Fill Out the Report Form",
        description:
          "Complete the user-friendly form, providing clear details about your issue.",
      },
      {
        label: "Submit Your Report",
        description:
          "Review and submit your report. A confirmation email will be sent.",
      },
      {
        label: "Receive Updates",
        description:
          "Check your email for updates, including notifications about scheduled meetings.",
      },
      {
        label: "Attend Your Appointment",
        description:
          "Meet with CSDL staff at the scheduled time to discuss your concern.",
      },
      {
        label: "Follow Up",
        description:
          "After your appointment, you can check the system for any follow-up actions or resolutions.",
      },
      {
        label: "Other Info",
        description:
          "If pending, you can edit or cancel the report. Once canceled, you can delete or reschedule with a new timeslot.",
      },
      {
        label: "Finish",
        description:
          "That’s it! You’re now ready to use the CSDL Report and Support System to get the help you need. If you have any questions, feel free to reach out to the CSDL office for support.",
      },
    ],
  },
  {
    label: "How to Submit a Report",
    icon: "report",
    description: "Submitting a report is quick and easy! Follow these steps:",
    subtopics: [
      {
        label: "Log In",
        description:
          "Access the CSDL Report and Support System with your student credentials.",
      },
      {
        label: "Click Plus Button",
        description:
          "On the dashboard, click the blue plus button to submit a new report.",
      },
      {
        label: "Choose a Category",
        description:
          "Select the category that best describes your issue (e.g., financial assistance, complaints).",
      },
      {
        label: "Fill Out the Report Form",
        description:
          "Provide detailed information to help the staff understand your issue.",
      },
      {
        label: "Choose a Schedule",
        description: "Pick a specific date and time for your appointment.",
      },
      {
        label: "Review Your Information",
        description:
          "Double-check the details to ensure everything is accurate.",
      },
      {
        label: "Submit Your Report",
        description:
          "Click the “Submit” button to file your report. You will receive an acknowledgment notification.",
      },
      {
        label: "Check for Updates",
        description:
          "Watch for notifications in the app about your report status and scheduled meetings.",
      },
      {
        label: "Finish",
        description:
          "That's it! Your report is now in the system, and the CSDL team will review it and get back to you as soon as possible. If you have any questions during the process, don’t hesitate to reach out for help!",
      },
    ],
  },
];
</script>
