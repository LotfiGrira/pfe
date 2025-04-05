<?php

namespace App\Services;

use App\Models\Hajb;

class HajbService
{
    protected $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function hajbBiAlab()
    {
        if ($this->input->hasAljad()) {
            $this->addHajb('ALJAD', 'ALAB');
        }
        $this->handleHajbForGroup('ALIKHWA_ALASHIKA', 'ALAB');
        $this->handleHajbForGroup('ALAKHAWAT_ASHAKIKAT', 'ALAB');
        $this->handleHajbForGroup('ALIKHWA_LI_OM', 'ALAB');
        $this->handleHajbForGroup('ALAKHAWAT_LI_OM', 'ALAB');
        $this->handleHajbForGroup('ALIKHWA_LI_AB', 'ALAB');
        $this->handleHajbForGroup('ALAKHAWAT_LI_AB', 'ALAB');
        $this->handleHajbForGroup('ABNA_ALIKHWA_ALASHIKA', 'ALAB');
        $this->handleHajbForGroup('ABNA_ALIKHWA_LI_AB', 'ALAB');
        $this->handleHajbForGroup('ALA3MAM_ALASHIKA', 'ALAB');
        $this->handleHajbForGroup('ALA3MAM_LI_AB', 'ALAB');
        $this->handleHajbForGroup('ABNA_ALA3MAM_ALASHIKA', 'ALAB');
        $this->handleHajbForGroup('ABNA_ALA3MAM_LI_AB', 'ALAB');
    }

    public function hajbBiAlom()
    {
        if (!empty($this->input['aljadah_li_ab'])) {
            $this->addHajb('الجدة للأب', 'الأم');
        }
        if (!empty($this->input['aljadah_li_om'])) {
            $this->addHajb('الجدة للأم', 'الأم');
        }
    }

    protected function handleHajbForGroup($group, $blocker)
    {
        $count = $this->input->getGroupCount($group);
        if ($count >= 1) {
            $this->addHajb($group, $count, $blocker);
        }
    }

    protected function addHajb($warith, $count = null, $blocker)
    {
        Hajb::create([
            'warith' => $warith,
            'count' => $count,
            'blocker' => $blocker
        ]);
    }
}
