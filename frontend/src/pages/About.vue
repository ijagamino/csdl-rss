<template>
  <PageHeader>Details About the Team</PageHeader>

  <section class="row">
    <p class="col-12">
      This system is dedicated to the Center for Student Development and
      Leadership (CSDL) office of Phinma-Araullo University.
    </p>
    <img class="col-12 col-md-6" src="~assets/csdl.jpg" alt="" />
  </section>

  <section class="mt-4">
    <header class="uppercase">
      <h2>Profiles</h2>
    </header>
    <div class="row">
      <q-item
        class="col-12 col-lg-6"
        v-for="member in members"
        :key="member.name"
        clickable
        v-ripple
      >
        <q-item-section side>
          <q-avatar size="128px">
            <img :src="member.image" alt="" />
            <!-- <img :src="member.image" alt="" /> -->
          </q-avatar>
        </q-item-section>
        <q-item-section>
          <q-item-label>{{ member.name }}</q-item-label>
          <q-item-label caption>{{ member.role }}</q-item-label>
        </q-item-section>
      </q-item>
    </div>
  </section>
</template>

<script setup>
// import feImage from "@/assets/fe.png";

const members = [
  {
    image: new URL("../assets/pm.jpg", import.meta.url).href,
    name: "Brienzell Kate Calpito",
    role: "Project Manager",
    link: "https://www.facebook.com/kitkit.342944",
  },
  {
    image: new URL("../assets/qa.jpg", import.meta.url).href,
    name: "Demi Rei Angeline Villareal",
    role: "QA Tester",
  },
  {
    image: new URL("../assets/fe.jpg", import.meta.url).href,
    name: "Luis Lei Pagdanganan",
    role: "Frontend Developer",
  },
  {
    image: "https://placehold.co/400",
    name: "Ivan Joshua Gamino",
    role: "Backend Developer",
  },
];
</script>
